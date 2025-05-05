<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    // Show upload form
    public function create()
    {
        return view('files.upload');
    }

    // Store uploaded file
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // 2MB max
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads');

        $user_id = Auth::user()->id;
        $employee = Employees::where('user_id', $user_id)->first();

        $uploadedFile = UploadedFile::create([
            'original_name' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'employeeID' => $employee->id,

        ]);
        
        return redirect()->route('home')
            ->with('success', 'File uploaded successfully!');
    }

    // List all files
    public function index()
    {
        $files = UploadedFile::all();
        return view('files.index', compact('files'));
    }

    // Download file
    public function download(UploadedFile $file)
    {
        return Storage::download($file->storage_path, $file->original_name);
    }
}