<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // for handling public_path
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

                // Generate ONE issuance number for this batch
                $issuanceNumber = 'ENZACT' . 
                \Carbon\Carbon::now()->format('Y') . 
                substr(md5($employee->employee_number . now()->timestamp), 0, 6);
            
            // Get all unreturned assigned items
            $items = AssignedItem::where('employeeID', $employee->id)
                ->where('item_status', 'unreturned')
                ->where('status', 0)
                ->get();
            
            // Create forms only for items that don't already have one
            foreach ($items as $item) {
                if (!AssetForm::where('assignedID', $item->id)->exists()) {
                    AssetForm::create([
                        'employeeID' => $employee->id,
                        'assignedID' => $item->id,
                        'issuance_number' => $issuanceNumber
                    ]);
                }
            }
        
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


                    // Generate ONE issuance number for this batch
                    $issuanceNumber = 'ENZACT' . 
                    \Carbon\Carbon::now()->format('Y') . 
                    substr(md5($employee->employee_number . now()->timestamp), 0, 6);
                
                // Get all unreturned assigned items
                // Retrieve the asset history items
                    $items = ItemHistory::where('employeeID', $employee->id)
                    ->orderBy('created_at', 'desc')
                    ->where('status', 0)
                    ->get();
                

                // Create forms only for items that don't already have one
                foreach ($items as $item) {
                    if (!ReturnForm::where('returnID', $item->id)->exists()) {
                        ReturnForm::create([
                            'employeeID' => $employee->id,
                            'returnID' => $item->id,
                            'issuance_number' => $issuanceNumber
                        ]);
                    }
                }
            
                // Get all forms related to the assigned items
                $return_forms = ReturnForm::with([
                    'returnItem.item.category',
                    'returnItem.item.brand',
                    'returnItem.item.unit'
                ])
                ->whereIn('returnID', $items->pluck('id'))
                ->get();    
    

        // Pass data to the PDF view
        $pdf = Pdf::loadView('pdf_asset_history', [
            'employee' => $employee,
            'return_forms' => $return_forms,
        ]);

        // Return the generated PDF to the browser
        return $pdf->download('asset_history.pdf');
    }
}
