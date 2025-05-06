<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnFile;
use App\Models\Employees;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReturnSignedItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'returnfile' => 'required|file|max:2048', // 2MB max
        ]);

        $file = $request->file('returnfile');
        $path = $file->store('uploads');

        $user_id = Auth::user()->id;
        $employee = Employees::where('user_id', $user_id)->first();

        $uploadedFile = ReturnFile::create([
            'employeeID' => $employee->id,
            'original_name' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),

        ]);
        
        return redirect()->route('home')
            ->with('success', 'File uploaded successfully!');
    }

    // Download file
    public function download(Employees $employee, ReturnFile $returnFile)
    {
 
        return Storage::download($returnFile->storage_path, $returnFile->original_name);
    }

}
