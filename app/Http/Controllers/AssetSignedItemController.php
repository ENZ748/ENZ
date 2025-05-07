<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetSignedItem;
use App\Models\Employees;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AssetSignedItemController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // 2MB max
        ]);
    
        $employee = Employees::findOrFail($id);
        $file = $request->file('file');
        $path = $file->store('assets_signed_files');
    
        // Save to database
        $uploadedFile = AssetSignedItem::create([
            'employeeID' => $employee->id,
            'original_name' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'type' => 'asset_signed'
        ]);
    
        return back()->with('success', 'Asset file uploaded successfully');
    }

    // Download file
    public function download(Employees $employee, ReturnFile $returnFile)
    {
 
        return Storage::download($returnFile->storage_path, $returnFile->original_name);
    }
}
