@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Uploaded Files</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <table class="table">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Uploaded At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{ $file->original_name }}</td>
                    <td>{{ $file->mime_type }}</td>
                    <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                    <td>{{ $file->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('files.download', $file) }}" class="btn btn-sm btn-primary">
                            Download
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <a href="{{ route('files.create') }}" class="btn btn-success">Upload New File</a>
</div>
@endsection