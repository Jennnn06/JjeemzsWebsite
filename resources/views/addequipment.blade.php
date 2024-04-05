<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Add Equipment')

<!-- Pass the content to layout -->
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var selectedStatusText;
        var selectedAvailableText;

        var isStatusGood;
        var isAvailable;
        
        //Function to check onLoad
        function onStart(){
            // DATE
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = currentDate.toLocaleString('default', { month: 'long' });
            var day = currentDate.getDate();

            $('#yearborrowedid').val(year);
            $('#monthborrowedid').val(month);
            $('#dateborrowedid').val(day);

            $('#yearreturnedid').val(year);
            $('#monthreturnedid').val(month);
            $('#datereturnedid').val(day);

            //OTHERS
            selectedStatusText = $('#equipmentsstatusvalue').find('option:selected').text();
            isStatusGood = (selectedStatusText === 'Good');

            selectedAvailableText = $('#equipmentsavailablevalue').find('option:selected').text();
            isAvailable = (selectedAvailableText === 'Yes');

            if(isStatusGood && isAvailable){
                $('#equipmentsreason').hide();

                $('#equipmentsborrowedby').hide();
                $('#equipmentslocation').hide();

                //Upload signature, quantity and date borrowed
                $('#fifthdiv').hide();

                //Requirements
                $('#equipmentsreasonvalue').prop('required', false);
                $('#equipmentsborrowedbyvalue').prop('required', false);
                $('#equipmentslocationvalue').prop('required', false);
            }
            else if(isStatusGood && !isAvailable){
                $('#equipmentsreason').hide();

                $('#equipmentsborrowedby').show();
                $('#equipmentslocation').show();

                $('#fifthdiv').show();

                //Requirements
                $('#equipmentsreasonvalue').prop('required', false);
                $('#equipmentsborrowedbyvalue').prop('required', true).show();
                $('#equipmentslocationvalue').prop('required', true).show();
            }
            else if(!isStatusGood){
                $('#equipmentsreason').show();

                $('#availtext').hide();
                $('#equipmentsavailable').hide();
                $('#equipmentsborrowedby').hide();
                $('#equipmentslocation').hide();

                $('#fifthdiv').hide();

                //Requirements
                $('#equipmentsreasonvalue').prop('required', true).show();
                $('#equipmentsborrowedbyvalue').prop('required', false);
                $('#equipmentslocationvalue').prop('required', false);
            }
            
        }

        //Check data once the website loads
        onStart();

        function onUpdate(){
            selectedStatusText = $('#equipmentsstatusvalue').find('option:selected').text();
            isStatusGood = (selectedStatusText === 'Good');

            selectedAvailableText = $('#equipmentsavailablevalue').find('option:selected').text();
            isAvailable = (selectedAvailableText === 'Yes');

            if(isStatusGood && isAvailable){
                //Reason
                $('#equipmentsreason').hide();

                //Texts
                $('#availtext').show();
                $('#equipmentsavailable').show();

                //Borrowed by and location
                $('#equipmentsborrowedby').hide();
                $('#equipmentslocation').hide();

                //Upload signature, quantity and date borrowed
                $('#fifthdiv').hide();

                //Requirements
                $('#equipmentsreasonvalue').prop('required', false);
                $('#equipmentsborrowedbyvalue').prop('required', false);
                $('#equipmentslocationvalue').prop('required', false);
                $('#equipmentsborrowedqtyvalue').prop('required', false);
            }
            else if(isStatusGood && !isAvailable){
                //Reason
                $('#equipmentsreason').hide();

                //Texts
                $('#availtext').show();
                $('#equipmentsavailable').show();
                
                //Borrowed by and location
                $('#equipmentsborrowedby').show();
                $('#equipmentslocation').show();

                //Upload signature, quantity and date borrowed
                $('#fifthdiv').show();

                //Requirements
                $('#equipmentsreasonvalue').prop('required', false);
                $('#equipmentsborrowedbyvalue').prop('required', true).show();
                $('#equipmentslocationvalue').prop('required', true).show();
                $('#equipmentsborrowedqtyvalue').prop('required', true).show();
            }
            else if(!isStatusGood){
                //Reason
                $('#equipmentsreason').show();

                //Texts
                $('#availtext').hide();
                $('#equipmentsavailable').hide();

                //Borrowed by and location
                $('#equipmentsborrowedby').hide();
                $('#equipmentslocation').hide();

                $('#fifthdiv').hide();

                //Requirements
                $('#equipmentsreasonvalue').prop('required', true).show();
                $('#equipmentsborrowedbyvalue').prop('required', false);
                $('#equipmentslocationvalue').prop('required', false);
                $('#equipmentsborrowedqtyvalue').prop('required', false);
            }
        }

        // Continuously update visibility when equipment status changes
        $('#equipmentsstatusvalue').change(function() {
            onUpdate();
        });

        $('#equipmentsavailablevalue').change(function() {
            onUpdate();
        });
        
        // Form submission event listener
        $('#addform').submit(function(event) {
            if (isStatusGood && isAvailable) {
                $('#equipmentsreasonvalue').val('');

                $('#equipmentsborrowedbyvalue').val('');
                $('#equipmentslocationvalue').val('');

                $('#equipmentsborrowedqtyvalue').val('');
                $('#monthborrowedid').val('');
                $('#dateborrowedid').val('');
                $('#yearborrowedid').val('');
            }
            else if (isStatusGood && !isAvailable){
                $('#equipmentsreasonvalue').val('');
            }
            else if (!isStatusGood){   
                $('#equipmentsavailablevalue').val('No');
                $('#equipmentsborrowedbyvalue').val('');
                $('#equipmentslocationvalue').val('');
                
                $('#equipmentsborrowedqtyvalue').val('');
                $('#monthborrowedid').val('');
                $('#dateborrowedid').val('');
                $('#yearborrowedid').val('');
            }

        });

        // COLORS SUGGESTIONS
        $('#equipmentscolorvalue').on('input', function() {
            var searchTerm = $(this).val();

            // Send AJAX request to fetch color suggestions
            $.ajax({
                url: '/addequipments/add',
                method: 'GET',
                data: {
                    query: searchTerm,
                    color: true // Specify that we are fetching color suggestions
                },
                success: function(response) {
                    // Update color suggestions
                    $('#colorSuggestions').empty();

                    // Limit the number of suggestions to 5
                    var suggestions = response.slice(0, 5);
                    
                    // Create bubbles for each suggestion
                    suggestions.forEach(function(suggestion) {
                        var bubble = $('<div class="color-bubble"></div>').text(suggestion);
                        
                        // Attach click event to each bubble
                        bubble.on('click', function() {
                            // Set the clicked suggestion as the input value
                            $('#equipmentscolorvalue').val(suggestion);
                            
                            // You can perform additional actions here if needed
                            
                            // Clear suggestions after selection
                            $('#colorSuggestions').empty();
                        });

                        // Append the bubble to the container
                        $('#colorSuggestions').append(bubble);
                    });
                    // If suggestions exceed 5, make them scrollable
                    if (response.length > 5) {
                        $('#colorSuggestions').addClass('scrollable');
                    } else {
                        $('#colorSuggestions').removeClass('scrollable');
                    }
                }
            });
        });

        // BRANDS SUGGESTIONS
        $('#equipmentsbrandvalue').on('input', function() {
            var searchTerm = $(this).val();

            // Send AJAX request to fetch brand suggestions
            $.ajax({
                url: '/addequipments/add',
                method: 'GET',
                data: {
                    query: searchTerm,
                    brand: true // Specify that we are fetching brand suggestions
                },
                success: function(response) {
                    // Update brand suggestions
                    $('#brandSuggestions').empty();

                    // Limit the number of suggestions to 5
                    var suggestions = response.slice(0, 5);
                    
                    // Create bubbles for each suggestion
                    suggestions.forEach(function(suggestion) {
                        var bubble = $('<div class="brand-bubble"></div>').text(suggestion);
                        
                        // Attach click event to each bubble
                        bubble.on('click', function() {
                            // Set the clicked suggestion as the input value
                            $('#equipmentsbrandvalue').val(suggestion);
                            
                            // You can perform additional actions here if needed
                            
                            // Clear suggestions after selection
                            $('#brandSuggestions').empty();
                        });

                        // Append the bubble to the container
                        $('#brandSuggestions').append(bubble);
                    });
                    // If suggestions exceed 5, make them scrollable
                    if (response.length > 5) {
                        $('#brandSuggestions').addClass('scrollable');
                    } else {
                        $('#brandSuggestions').removeClass('scrollable');
                    }
                }
            });
        });

        // Add 'required' attribute to equipmentsnamevalue and equipmentsqtyvalue
        $('#equipmentsnamevalue, #equipmentsqtyvalue').prop('required', true);

    });
</script>

<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px;">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Add an Equipment</p>
            <br>
        </div>
        
        <div style="margin-left: 20px; margin-top: 20px">
        <form id="addform" method="post" action="{{route('addequipments.store')}}" enctype="multipart/form-data">
            @csrf
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <p>{{ $error }}</p>
                </div>
            @endforeach
            
            <!-- Equipment Info -->
            <p style="color: white; font-size: 25px;">Information</p>

            <!-- 1st Div -->
            <div class="mb-3" style="display: flex; flex-direction: row; width: 1000px; justify-content: space-between">
                <!-- Upload Image -->
                <div class="mb-3">
                    <label for="formFile" class="form-label col-sm-2" style="color: #f0f0f0; width: 200px">Upload Image:</label>
                    <input class="form-control" name="upload" type="file" id="formFile" accept="image/*" style="width: 280px">
                    @error('upload')
                    <div class="invalid-feedback" style="display: block;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Equipment name -->
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0; width: 200px">Equipment Name: </label>
                    <input class="form-control" id="equipmentsnamevalue" name="equipmentsname" type="text" placeholder="Enter equipment name" style="width: 330px">
                    <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
                </div>

                <!-- Equipments SERIAL NUMBER -->
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0; width: 200px">Serial Number: </label>
                    <input class="form-control" name="equipmentsserialnumber" type="text" placeholder="Enter equipment serial number" style="width: 300px">
                </div>
                
            </div>

            <!-- 2nd Div -->
            <div class="mb-3" style="display: flex; flex-direction: row; width: 1000px; ">

                <!-- Equipment brand -->
                <div class="mb-3" style="position: relative">
                    <label class="col-sm-2 form-label" style="color: #f0f0f0;">Brand: </label>
                    <input id="equipmentsbrandvalue" class="form-control" name="equipmentsbrand" type="text" placeholder="Enter brand name" style="width: 250px; margin-right: 50px">
                    <div id="brandSuggestions" class="suggestions-container" style="background-color:white; color: #000000; border-radius: 5px; position: absolute; top: 100%; left: 0; z-index: 100; width: 260px; font-size: 20px; cursor: default;"></div>
                </div>

                <!-- Color -->
                <div class="mb-3" style="position: relative">
                    <label class="col-sm-2 form-label" style="color: #f0f0f0; ">Color: </label>
                    <input id="equipmentscolorvalue" class="form-control" name="equipmentscolor" type="text" placeholder="Color" style="width: 250px; margin-right: 50px">
                    <div id="colorSuggestions" class="suggestions-container" style="background-color:white; color: #000000; border-radius: 5px; position: absolute; top: 100%; left: 0; z-index: 100; width: 260px; font-size: 20px;"></div>
                </div>

                <!-- Equipment quantity -->
                <div class="mb-3">
                    <label class="col-sm-2 form-label" style="color: #f0f0f0; ">Quantity: </label>
                    <input class="form-control" id="equipmentsqtyvalue" name="equipmentsqty" type="number" placeholder="0" style="width: 150px; margin-right: 50px">
                </div>

                <!-- Folder -->
                <div class="mb-3">
                    <label class="col-sm-2 form-label" style="color: #f0f0f0">Folder: </label>
                    <select class="form-select" name="equipmentsfolder" aria-label="Default select example" style="width: 200px; margin-right: 50px">
                        <!--Palitan based sa folder na ginawa-->
                        <option value="" selected>Select Folder</option>
                        @foreach($equipmentsfolders as $folder)
                            <option>{{ $folder->equipmentsname }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>

            <!-- Status -->
            <p style="color: white; font-size: 25px; margin-top: 50px">Status</p>

            <!-- 3rd Div -->
            <div class="mb-3" style="display: flex; flex-direction: row; width: 1000px; justify-content: space-between">
                <!-- Status -->
                <div class="mb-3">
                    <label class="col-sm-2 form-label" style="color: #f0f0f0;">Status: </label>
                    <select id="equipmentsstatusvalue" class="form-select" name="equipmentsstatus" aria-label="Default select example" style="width: 350px; margin-right: 50px">
                        <option selected>Good</option>
                        <option value="Defective">Defective</option>
                        <option value="For Repair">For Repair</option>
                        <option value="Lost">Lost</option>
                    </select>
                </div>

                <!-- Reason -->
                <div class="mb-3" id="equipmentsreason">
                    <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Reason: </label>
                    <input id="equipmentsreasonvalue" class="form-control" name="equipmentsreason" type="text" placeholder="Reason" style="width: 300px">
                </div>
            </div>

            <!-- Availability -->
            <p id="availtext" style="color: white; font-size: 25px; margin-top: 50px">Availability</p>

            <!-- 4th Div -->
            <div id="equipmentsavailable" class="mb-3" style="display: flex; flex-direction: row; justify-content:space-between; width: 1000px">
                <!-- Available -->
                <div class="mb-3" >
                    <label class="col-sm-2 form-label" style="color: #f0f0f0">Availability: </label>
                    <select id="equipmentsavailablevalue" class="form-select" name="equipmentsavailable" aria-label="Default select example" style="width: 300px">
                        <option selected>Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <!-- Borrowed by -->
                <div class="mb-3" id="equipmentsborrowedby">
                    <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0; width: 200px">Borrowed by: </label>
                    <input id="equipmentsborrowedbyvalue" class="form-control" name="equipmentsborrowedby" type="text" placeholder="Borrowed by" style="width: 300px">
                    <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
                </div>
                
                <!-- Location -->
                <div class="mb-3" id="equipmentslocation">
                    <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Location: </label>
                    <input id="equipmentslocationvalue" class="form-control" name="equipmentslocation" type="text" placeholder="Location" style="width: 300px">
                    <span class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Required.</span>
                </div>
            </div>

            <!-- 5th Div FOR BORROWING-->
            <div class="mb-3" id="fifthdiv" style="display: flex; flex-direction: row; width: 1000px; justify-content: space-between">
                
                <!-- Upload Signature -->
                <div class="mb-3">
                    <label for="formFile" class="form-label col-sm-2" style="color: #f0f0f0; width: 300px">Upload Signature (Optional):</label>
                    <input id="uploadsignaturevalue" class="form-control" name="uploadsignature" type="file" id="formFile" accept="image/*" style="width: 250px">
                    @error('upload')
                    <div class="invalid-feedback" style="display: block;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Borrowed Quantity -->
                <div class="mb-3">
                    <label class="col-sm-2 form-label" style="color: #f0f0f0; ">Quantity: </label>
                    <input id="equipmentsborrowedqtyvalue" class="form-control" name="equipmentsborrowedqty" type="number" placeholder="0" style="width: 150px; margin-right: 50px">
                </div>

                <!-- Date borrowed -->
                <div class="mb-3">
                    <label class="col-sm-2 form-label" style="color: #f0f0f0; width: 250px">Date borrowed: </label>
                    <div style="display: flex; flex-direction: row; width: 450px">
                        {{-- SELECT MONTH --}}
                        <select id="monthborrowedid" class="form-select" name="monthborrowed" aria-label="Default select example" style="margin-right: 20px">
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>

                        {{-- SELECT DATE --}}
                        <select id="dateborrowedid" class="form-select" name="dateborrowed" aria-label="Default select example" style="margin-right: 20px">
                            @for ($day = 1; $day <= 31; $day++)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endfor
                        </select>

                        {{-- SELECT YEAR --}}
                        <select id="yearborrowedid" class="form-select" name="yearborrowed" aria-label="Default select example"  >
                            @for ($year = 2020; $year <= 2050; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    
                </div>

            </div>

            <!-- Note -->
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Note: </label>
                <input class="form-control" name="equipmentsnote" type="text" placeholder="Note" style="width: 300px; height: 100px">
            </div>
            

            <div style="display: flex; justify-content: flex-end">
                <input type="submit" class="btn btn-primary mb-3" style="width: 150px; height: 70px; background-color: #779933; color: #fff">
            </div>
        </form>
    </div>
</div>
@endsection