<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Add Equipment')

<!-- Pass the content to layout -->
@section('content')
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px;">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Add an Equipment</p>
            <br>
        </div>
        
        <div style="margin-left: 20px; margin-top: 20px">
        <form method="post" action="{{route('addequipments.store')}}" enctype="multipart/form-data">
            @csrf

            <!-- Upload Image -->
            <div class="mb-3 row">
                <label for="formFile" class="form-label col-sm-2" style="color: #f0f0f0">Upload Image:</label>
                <input class="form-control" name="upload" type="file" id="formFile" accept="image/*" style="width: 300px">
                @error('upload')
                <div class="invalid-feedback" style="display: block;">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Equipments SERIAL NUMBER -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Serial Number: </label>
                <input class="form-control" name="equipmentsserialnumber" type="text" placeholder="Enter equipment serial number" style="width: 300px">
                <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
            </div>

            <!-- Equipment name -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Equipment Name: </label>
                <input class="form-control" name="equipmentsname" type="text" placeholder="Enter equipment name" style="width: 300px">
                <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
            </div>

            <!-- Equipment brand -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Brand: </label>
                <input class="form-control" name="equipmentsbrand" type="text" placeholder="Enter brand name" style="width: 300px">
            </div>

            <!-- Color -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Color: </label>
                <input class="form-control" name="equipmentscolor" type="text" placeholder="Color" style="width: 300px">
            </div>

            <!-- Equipment quantity -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Quantity: </label>
                <input class="form-control" name="equipmentsqty" type="number" placeholder="0" style="width: 300px">
            </div>

            <!-- Status -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Status: </label>
                <select class="form-select" name="equipmentsstatus" aria-label="Default select example" style="width: 300px">
                    <option selected>Good</option>
                    <option value="Defective">Defective</option>
                    <option value="For Repair">For Repair</option>
                    <option value="Lost">Lost</option>
                </select>
            </div>

            <!-- Available -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Availability: </label>
                <select class="form-select" name="equipmentsavailable" aria-label="Default select example" style="width: 300px">
                    <option selected>Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <!-- IN_OUT -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">In / Out: </label>
                <select class="form-select" name="equipmentsinout" aria-label="Default select example" style="width: 300px">
                    <option selected>In shop</option>
                    <option value="Out">Out</option>
                </select>
            </div>

            <!-- Borrowed by -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Borrowed by: </label>
                <input class="form-control" name="equipmentsborrowedby" type="text" placeholder="Borrowed by" style="width: 300px">
                <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
            </div>

            <!-- Location -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Location: </label>
                <input class="form-control" name="equipmentslocation" type="text" placeholder="Location" style="width: 300px">
                <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
            </div>
            
            <!-- Reason -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Reason: </label>
                <input class="form-control" name="equipmentsreason" type="text" placeholder="Reason" style="width: 300px">
            </div>

            <!-- Note -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Note: </label>
                <input class="form-control" name="equipmentsnote" type="text" placeholder="Note" style="width: 300px">
            </div>

            <!-- Folder -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Folder: </label>
                <select class="form-select" name="equipmentsfolder" aria-label="Default select example" style="width: 300px">
                    <!--Palitan based sa folder na ginawa-->
                    <option value="" selected>Select Folder</option>
                    @foreach($equipmentsfolders as $folder)
                        <option>{{ $folder->equipmentsname }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-left: 360px; margin-top:50px">
                <input type="submit" class="btn btn-primary mb-3" style="width: 100px; height: 45px; background-color: #779933; color: #fff">
            </div>
        </form>
    </div>
</div>
@endsection