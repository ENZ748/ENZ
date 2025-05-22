<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Employees;
use App\Models\AssignedItem;
use App\Models\ItemHistory;
use App\Models\AssetForm;
use App\Models\ReturnForm;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Get the current user ID
        $user_id = Auth::user()->id;

        // Find the employee associated with the current user
        $employee = Employees::where('user_id', $user_id)->first();


            // Get all unreturned assigned items
            $items = AssignedItem::where('employeeID', $employee->id)
                ->where('item_status', 'unreturned')
                ->where('status', 0)
                ->get();


                $lastAssetForm = AssetForm::latest()->first(); 

                if ($lastAssetForm && $lastAssetForm->assignedItem && $lastAssetForm->assignedItem->status == 0) {

                    foreach ($items as $item) {
                        if (!AssetForm::where('assignedID', $item->id)->exists()) {
                            AssetForm::create([
                                'employeeID' => $employee->id,
                                'assignedID' => $item->id,
                                'issuance_number' => $lastAssetForm->issuance_number
                            ]);
                        }
        
                    }
                }
                else{
                    // Generate ONE issuance number for this batch
                    $issuanceNumber = 'ENZACT' . 
                    \Carbon\Carbon::now()->format('Y') . 
                    substr(md5($employee->employee_number . now()->timestamp), 0, 6);
                
                    foreach ($items as $item) {
                        if (!AssetForm::where('assignedID', $item->id)->exists()) {
                            AssetForm::create([
                                'employeeID' => $employee->id,
                                'assignedID' => $item->id,
                                'issuance_number' => $issuanceNumber
                            ]);
                        }
        
                    }
                }
                

            // Create forms only for items that don't already have one


              
        
            // Get all forms related to the assigned items
            $item_forms = AssetForm::with([
                'assignedItem.item.category',
                'assignedItem.item.brand',
                'assignedItem.item.unit'
            ])
            ->whereIn('assignedID', $items->pluck('id'))
            ->get();    

        // Encode the image to base64
        $logo_path = public_path('ENZPDF.png'); // Path to your image
        $logo = base64_encode(file_get_contents($logo_path)); // Encode the image as base64

        // Pass the data to the view and generate the PDF
        $pdf = Pdf::loadView('pdf_view', [
            'employee' => $employee,
            'item_forms' => $item_forms,
            'logo' => $logo, // Pass the base64-encoded logo to the view
        ]);

        // Return the generated PDF to the browser
        return $pdf->download('Accountability Form.pdf');
    }


    public function AssetHistoryGeneratePDF()
    {
        $user_id = Auth::user()->id;
        $employee = Employees::where('user_id', $user_id)->first();
    
        if (!$employee) {
            abort(404, 'Employee not found');
        }
    
        $items = ItemHistory::with(['item.category', 'item.brand', 'item.unit'])
            ->where('employeeID', $employee->id)
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();
    
            if ($items->isEmpty()) {
                $pdf = Pdf::loadView('pdf_asset_history', [
                    'employee' => $employee,
                    'item_forms' => collect(),
                    'return_forms' => collect(),
                ]);
                return $pdf->download('asset_history.pdf');
            }
        
            // Check if all items already have ReturnForms
            $allItemsHaveReturnForms = true;
            foreach ($items as $item) {
                if (!$item->returnForm) {
                    $allItemsHaveReturnForms = false;
                    break;
                }
            }
        
            // If all items already have ReturnForms, return PDF with existing data
            if ($allItemsHaveReturnForms) {
                $return_forms = ReturnForm::whereIn('returnID', $items->pluck('id'))->get();
                $pdf = Pdf::loadView('pdf_asset_history', [
                    'employee' => $employee,
                    'item_forms' => collect(),
                    'return_forms' => $return_forms,
                ]);
                return $pdf->download('asset_history.pdf');
            }
    
        $assigned_items = AssignedItem::whereIn('itemID', $items->pluck('itemID'))->get();
        $item_forms = AssetForm::with([
            'assignedItem.item.category',
            'assignedItem.item.brand',
            'assignedItem.item.unit'
        ])->whereIn('assignedID', $assigned_items->pluck('id'))->get();
    
        $issuanceNumbers = [];
        $matchedForms = [];
        $hasNewItem = false;
    
        foreach ($items as $item) {
            foreach ($item_forms as $form) {
                if (
                    optional($form->assignedItem->item->category)->category_name === optional($item->item->category)->category_name &&
                    optional($form->assignedItem->item->brand)->brand_name === optional($item->item->brand)->brand_name &&
                    optional($form->assignedItem->item->unit)->unit_name === optional($item->item->unit)->unit_name &&
                    optional($form->assignedItem->item)->serial_number === optional($item->item)->serial_number
                ) {
                    $issuanceNumbers[] = $form->issuance_number;
                    $matchedForms[$item->id] = $form;
    
                    $existingReturnForm = ReturnForm::where('returnID', $item->id)->first();
                    if (!$existingReturnForm) {
                        $hasNewItem = true;
                    }
    
                    break;
                }
            }
        }
    
        if (!$hasNewItem && empty($matchedForms)) {
            // No new items or matched forms, skip PDF generation
            return back()->with('message', 'No new asset history to generate.');
        }
    
        // Determine the issuance number to use
        $uniqueIssuances = array_unique($issuanceNumbers);
        if (count($uniqueIssuances) === 1) {
            $issuanceNumber = $uniqueIssuances[0];
        } else {
            $baseIssuanceNumber = 'ENZACT' . now()->format('Y') . substr(md5($employee->employee_number . now()->timestamp), 0, 6);
            $issuanceNumber = $baseIssuanceNumber;
            $suffix = 1;
            while (ReturnForm::where('issuance_number', $issuanceNumber)->exists()) {
                $issuanceNumber = $baseIssuanceNumber . '-' . $suffix++;
            }
        }
    
        // Create or update return forms
        foreach ($items as $item) {
            if (!isset($matchedForms[$item->id])) {
                continue;
            }
    
            $form = $matchedForms[$item->id];
            $existingReturnForm = ReturnForm::where('returnID', $item->id)->first();
    
            if ($existingReturnForm) {
                // Update only if issuance number is different
                if ($existingReturnForm->issuance_number !== $issuanceNumber) {
                    $existingReturnForm->update([
                        'asset_formID' => $form->id,
                        'issuance_number' => $issuanceNumber,
                    ]);
                }
            } else {
                ReturnForm::create([
                    'asset_formID' => $form->id,
                    'issuance_number' => $issuanceNumber,
                    'returnID' => $item->id,
                ]);
            }
        }
    
        $return_forms = ReturnForm::whereIn('returnID', $items->pluck('id'))->get();
    
        $pdf = Pdf::loadView('pdf_asset_history', [
            'employee' => $employee,
            'item_forms' => $item_forms,
            'return_forms' => $return_forms,
        ]);
    
        return $pdf->download('asset_history.pdf');
    }
    
    
    
    
}
