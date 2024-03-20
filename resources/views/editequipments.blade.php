<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Edit Equipment')

<!-- Pass the content to layout -->
@section('content')

<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px;">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Edit Equipment</p>
            <br>
        </div>
        
        <div style="margin-left: 20px; margin-top: 20px">
        <form method="post" action="{{route('editequipments.update', ['id' => $editequipment->id])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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

            <!-- Equipment name -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Equipment Name: </label>
                <input class="form-control" name="equipmentsname" type="text" value="{{$editequipment->ITEM_NAME}}" placeholder="Enter equipment name" style="width: 300px">
                <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
            </div>

            <!-- Equipment brand -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Brand: </label>
                <input class="form-control" name="equipmentsbrand" type="text" value="{{$editequipment->BRAND}}" placeholder="Enter brand name" style="width: 300px">
            </div>

            <!-- Color -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Color: </label>
                <input class="form-control" name="equipmentscolor" type="text" value="{{$editequipment->COLOR}}" placeholder="Color" style="width: 300px">
            </div>

            <!-- Equipment quantity -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Quantity: </label>
                <input class="form-control" name="equipmentsqty" type="number" value="{{$editequipment->QUANTITY}}" placeholder="0" style="width: 300px">
            </div>

            <!-- Status -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Status: </label>
                <select class="form-select" name="equipmentsstatus" aria-label="Default select example" value="{{$editequipment->STATUS}}" style="width: 300px">
                    <option selected>Good</option>
                    <option value="Defective">Defective</option>
                    <option value="For Repair">For Repair</option>
                    <option value="Lost">Lost</option>
                </select>
            </div>

            <!-- Available -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Availability: </label>
                <select class="form-select" name="equipmentsavailable" aria-label="Default select example" value="{{$editequipment->AVAILABLE}}" style="width: 300px">
                    <option selected>Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <!-- IN_OUT -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">In / Out: </label>
                <select class="form-select" name="equipmentsinout" aria-label="Default select example" value="{{$editequipment->IN_OUT}}" style="width: 300px">
                    <option selected>In shop</option>
                    <option value="Out">Out</option>
                </select>
            </div>
            
            <!-- Reason -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Reason: </label>
                <input class="form-control" name="equipmentsreason" type="text" value="{{$editequipment->REASON}}" placeholder="Reason" style="width: 300px">
            </div>

            <!-- Note -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Note: </label>
                <input class="form-control" name="equipmentsnote" type="text" value="{{$editequipment->NOTE}}" placeholder="Note" style="width: 300px">
            </div>

            <!-- Folder -->
            <div class="mb-3 row">
                <label class="col-sm-2 form-label" style="color: #f0f0f0">Folder: </label>
                <select class="form-select" name="equipmentsfolder" aria-label="Default select example" style="width: 300px">
                    <!--Palitan based sa folder na ginawa-->
                    <option value="" {{ $editequipment->FOLDER ? '' : 'selected' }}>Select Folder</option>
                    
                    <!-- Check if $equipmentsfolders is not empty -->
                    @if(!$equipmentsfolder->isEmpty())
                        <!-- Loop through $equipmentsfolders if not empty -->
                        @foreach($equipmentsfolder as $folder)
                            <option value="{{ $folder->equipmentsname }}" {{ $editequipment->FOLDER == $folder->equipmentsname ? 'selected' : '' }}>
                                {{ $folder->equipmentsname }}
                            </option>
                        @endforeach
                 @endif
                </select>
            </div>

            <div style="margin-left: 360px; margin-top:50px">
                <input type="submit" class="btn btn-primary mb-3" style="width: 100px; height: 45px; background-color: #779933; color: #fff">
            </div>
        </form>
    </div>
</div>
@endsection