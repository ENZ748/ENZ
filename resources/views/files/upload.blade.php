@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload File</h1>
    
    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="file">Choose File</label>
            <input type="file" class="form-control-file" id="file" name="file" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection 