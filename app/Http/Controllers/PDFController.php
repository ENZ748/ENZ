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
        // Get the current user ID
        $user_id = Auth::user()->id;
    
        // Find the employee associated with the current user
        $employee = Employees::where('user_id', $user_id)->first();
    
        if (!$employee) {
            abort(404, 'Employee not found');
        }
    
        // Generate ONE issuance number for this batch
        $issuanceNumber = 'ENZACT' . 
            \Carbon\Carbon::now()->format('Y') . 
            substr(md5($employee->employee_number . now()->timestamp), 0, 6);
    
        // Get all unreturned assigned items from history with relationships
        $items = ItemHistory::with(['item.category', 'item.brand', 'item.unit'])
            ->where('employeeID', $employee->id)
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Get assigned items matching those item IDs
        $assigned_items = AssignedItem::whereIn('itemID', $items->pluck('itemID'))->get();
    
        // Get all forms related to the assigned items with relationships
        $item_forms = AssetForm::with([
            'assignedItem.item.category',
            'assignedItem.item.brand',
            'assignedItem.item.unit'
        ])->whereIn('assignedID', $assigned_items->pluck('id'))->get();
        
        // Compare each return item with each assigned item and create forms if needed
        foreach ($items as $item) {
            if (!ReturnForm::where('returnID', $item->id)->exists()) {
                $matched = false;
                $matchedForm = null;
    
                // Try to find a matching assigned item
                foreach ($item_forms as $form) { 
                    if ($form->assignedItem && $form->assignedItem->item && $item->item) {
                        if (
                            optional($form->assignedItem->item->category)->category_name === optional($item->item->category)->category_name &&
                            optional($form->assignedItem->item->brand)->brand_name === optional($item->item->brand)->brand_name &&
                            optional($form->assignedItem->item->unit)->unit_name === optional($item->item->unit)->unit_name
                        ) {
                            $matchedForm = $form;
                            $matched = true;
                            break;
                        }
                    }
                }
    
                if ($matched && $matchedForm) {
                    ReturnForm::create([
                        'asset_formID' => $matchedForm->id,
                        'issuance_number' => $matchedForm->issuance_number,
                        'returnID' => $item->id
                    ]);
                } else {
                    // Use first available form if no match found
                    $firstForm = $item_forms->first();
                    if ($firstForm) {
                        ReturnForm::create([
                            'asset_formID' => $firstForm->id,
                            'issuance_number' => $issuanceNumber,
                            'returnID' => $item->id
                        ]);
                    }
                }
            }
        }
        
        // Get all return forms related to these item forms
        $return_forms = ReturnForm::whereIn('returnID', $items->pluck('id'))->get();
    
        // Pass data to the PDF view
        $pdf = Pdf::loadView('pdf_asset_history', [
            'employee' => $employee,
            'item_forms' => $item_forms,
            'return_forms' => $return_forms,
        ]);
    
        return $pdf->download('asset_history.pdf');
    }
}
