@extends('layout')

@section('title', 'Edit Folder')

@section('content')
<div class="container">
    <h2 style="color: white">Edit Folder</h2>
    <form action="{{ route('equipments.updatefolder', ['id' => $folder->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="equipmentsname" style="color: white">Folder Name:</label>
            <input type="text" class="form-control" id="equipmentsname" name="equipmentsname" value="{{ $folder->equipmentsname }}" required>
            @error('equipmentsname')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="equipmentsimage" style="color: white">Upload New Image:</label>
            <input type="file" class="form-control" id="equipmentsimage" name="equipmentsimage">
            @error('equipmentsimage')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Update Folder</button>
    </form>
</div>

@endsection

