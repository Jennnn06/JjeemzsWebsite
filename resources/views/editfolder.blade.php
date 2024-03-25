@extends('layout')

@section('title', 'Edit Folder')

@section('content')
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; height:100vh">

        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Edit Folder</p>
        </div>

        <div style="margin-left: 20px; margin-top: 20px">
            <form action="{{ route('equipments.updatefolder', ['id' => $folder->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <p>{{ $error }}</p>
                    </div>
                @endforeach

                <div class="mb-3 row">
                    <label for="equipmentsimage" class="form-label col-sm-2" style="color: #f0f0f0">Upload New Image:</label>
                    <input class="form-control" type="file" class="form-control" id="equipmentsimage" name="equipmentsimage" style="width: 300px">
                </div>

                <div class="mb-3 row">
                    <label for="equipmentsname" class="form-label col-sm-2" style="color: #f0f0f0">Folder Name:</label>
                    <input type="text" class="form-control" id="equipmentsname" name="equipmentsname" value="{{ $folder->equipmentsname }}" style="width: 300px" required>
                    <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
                </div>
                
                <!-- Submit button -->
                <div style="margin-left: 360px; margin-top:50px">
                    <button type="submit" class="btn btn-primary mb-3" style="width: 150px; height: 60px; background-color: #779933; color: #fff">Update Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

