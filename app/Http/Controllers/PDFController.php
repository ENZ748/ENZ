<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // for handling public_path
use App\Models\Employees;
use App\Models\AssignedItem;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Get the current user ID
        $user_id = Auth::user()->id;

        // Find the employee associated with the current user
        $employee = Employees::where('user_id', $user_id)->first();

        // Retrieve all assigned items for the employee that are unreturned and have status 0
        $assigned_items = AssignedItem::where('employeeID', $employee->id)
            ->where('item_status', 'unreturned')
            ->where('status', 0)
            ->get();

        // Update the status of the assigned items to 1 (or any other status you wish)
        foreach ($assigned_items as $assigned_item) {
            $assigned_item->status = 1; // Update the status to 1 (you can change this if needed)
            $assigned_item->save(); // Save the change to the database
        }

        // Encode the image to base64
        $logo_path = public_path('ENZPDF.png'); // Path to your image
        $logo = base64_encode(file_get_contents($logo_path)); // Encode the image as base64

        // Pass the data to the view and generate the PDF
        $pdf = Pdf::loadView('pdf_view', [
            'employee' => $employee,
            'assigned_items' => $assigned_items,
            'logo' => $logo, // Pass the base64-encoded logo to the view
        ]);

        // Return the generated PDF to the browser
        return $pdf->download('Accountability Form.pdf');
    }
}
