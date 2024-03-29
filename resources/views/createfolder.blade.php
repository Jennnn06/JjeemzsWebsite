<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Create Folder')

<!-- Pass the content to layout -->
@section('content')
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; height:100vh">

        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Create folder of tool</p>
        </div>
        
        <div style="margin-left: 20px; margin-top: 20px">
        <form method="post" action="{{route('createfolder.post')}}" enctype="multipart/form-data">
            @csrf

            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <p>{{ $error }}</p>
                </div>
            @endforeach

            <!-- Upload Image -->
            <div class="mb-3 row">
                <label for="formFile" class="form-label col-sm-2" style="color: #f0f0f0">Upload Image:</label>
                <input class="form-control" name="equipmentsimage" type="file" id="formFile" accept="image/*" style="width: 300px">
            </div>
            
            <!-- Folder name -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Folder name: </label>
                <input class="form-control" name="equipmentsname" type="text" placeholder="Enter folder name" style="width: 300px">
                <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
            </div>

            <div style="margin-left: 360px; margin-top:50px">
                <button type="submit" class="btn btn-primary mb-3" style="width: 150px; height: 60px; background-color: #779933; color: #fff">Create Folder</input>
            </div>
        </form>
    </div>
</div>
@endsection