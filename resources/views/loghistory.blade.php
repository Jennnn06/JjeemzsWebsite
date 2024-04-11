<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Log History')

<!-- Pass the content to layout -->
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
    
        function onStart(){
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = currentDate.toLocaleString('default', { month: 'long' });
            var day = currentDate.getDate();

            $('#selectYearDropdown').val(year);
            $('#selectMonthDropdown').val(month);
            $('#selectDateDropdown').val(day);

            $('#equipmentDiv').hide();
            $('#equipmentTable').hide();
            
            populateDaysDropdown();
            updateTableData();
        }

        function updateTableData() {
            var month = $('#selectMonthDropdown').val();
            var year = $('#selectYearDropdown').val();
            var selectDate = $('#selectDateDropdown').val();

            $.ajax({
                url: '{{ route('loghistory') }}',
                method: 'GET',
                data: {
                    monthselect: month,
                    dateselect: selectDate,
                    yearselect: year
                },
                success: function(response) {
                    $('#borrowedTodayID').html(response.borrowedTodayHTML);
                    $('#returnedTodayID').html(response.returnedTodayHTML);
                    $('#equipmentTable').html(response.searchEquipmentsHTML);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        onStart();

        //FIX
        function populateDaysDropdown() {
            var month = $('#selectMonthDropdown').val();
            var year = $('#selectYearDropdown').val();
            var selectDate = $('#selectDateDropdown');
            
            // Store the current selected day
            var selectedDay = selectDate.val();
            
            // Clear existing options
            selectDate.empty();
            
            // Calculate days in the selected month
            var daysInMonth;
            switch (month) {
                case "January":
                case "March":
                case "May":
                case "July":
                case "August":
                case "October":
                case "December":
                    daysInMonth = 31;
                    break;
                case "April":
                case "June":
                case "September":
                case "November":
                    daysInMonth = 30;
                    break;
                case "February":
                    // Check for leap year
                    var isLeapYear = (year % 4 == 0 && year % 100 != 0) || (year % 400 == 0);
                    daysInMonth = isLeapYear ? 29 : 28;
                    break;
                default:
                    daysInMonth = 0;
            }
            
            // Add options for each day in the month
            for (var i = 1; i <= daysInMonth; i++) {
                selectDate.append('<option value="' + i + '">' + i + '</option>');
            }
            
            // Set the selected day back to its original value
            selectDate.val(selectedDay);
        }


        $('#equipmentdateSelector').change(function(){

            var EquipmentorDate = $('#equipmentdateSelector').val();

            if(EquipmentorDate === 'Date'){
                $('#dateDiv').show();
                $('#dateTable').show();

                $('#equipmentDiv').hide();
                $('#equipmentTable').hide();
            }
            else if(EquipmentorDate === 'Equipment'){
                $('#dateDiv').hide();
                $('#dateTable').hide();

                $('#equipmentDiv').show();
                $('#equipmentTable').show();
            }
            
        });

        //If nabago ung month, magbabago rin options, for example leap year
        $('#selectMonthDropdown, #selectDateDropdown, #selectYearDropdown').change(function() {
            var month = $('#selectMonthDropdown').val();
            var year = $('#selectYearDropdown').val();
            var selectDate = $('#selectDateDropdown').val();
            
            populateDaysDropdown();

            $.ajax({
                url: '{{ route('loghistory') }}',
                method: 'GET',
                data: {
                    monthselect: month,
                    dateselect: selectDate,
                    yearselect: year
                },
                success: function(response) {
                    $('#borrowedTodayID').html(response.borrowedTodayHTML);
                    $('#returnedTodayID').html(response.returnedTodayHTML);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
 
        });

        $('#searchBarID').on('input', function() {
            var searchTerm = $('#searchBarID').val();

            $.ajax({
                url: '{{ route('loghistory') }}', // Route to handle the search request on the server
                method: 'GET',
                data: { 
                    search: searchTerm,
                },
                success: function(response) {
                    $('#equipmentTable').html(response.searchEquipmentsHTML); // Update the users table with search results
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Log any errors to the console
                }
            });
        });
    
});

</script>

<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828; min-height: 100vh;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px;">
        {{-- <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Log History</p>
        </div> --}}

        {{-- Search Options --}}
        <div style="display: flex; flex-direction: column;">

            <!-- Select Equipment/Date -->
            <div id="equipmentdateDiv" style="width: 700px; display: flex; flex-direction: row; margin-bottom: 20px; ">
                <label style="color: #f0f0f0; margin-right: 29px">Search by Equipment/Date:</label>
                {{-- Select if Date or equipment --}}
                <div style="width: 200px; display: flex;">
                    <select id="equipmentdateSelector" class="form-select" aria-label="Default select example" >
                        <option value="Date" selected>Date</option>
                        <option value="Equipment">Equipment</option>
                      </select>
                </div>
            </div>

            <!-- Select date if you choose date-->
            <div id="dateDiv" style="display:flex; flex-direction:row;">
                <label class="form-label" style="color: #f0f0f0; margin-right: 140px">Select Date:</label>
                
                <div class="selectDate" style="width: 550px; display: flex; flex-direction: row; ">
                    {{-- SELECT MONTH --}}
                    <select name="monthselect" class="form-select" aria-label="Default select example" id="selectMonthDropdown" style="margin-right: 50px">
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
                    <select name="dateselect" class="form-select" aria-label="Default select example" id="selectDateDropdown" style="margin-right: 50px">
                        @for ($day = 1; $day <= 31; $day++)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endfor
                    </select>

                    {{-- SELECT YEAR --}}
                    <select name="yearselect" class="form-select" aria-label="Default select example" id="selectYearDropdown" >
                        @for ($year = 2020; $year <= 2050; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            
            </div>

            {{-- Search equipment if you choose equipment --}}
            <div id="equipmentDiv" style="align-items: flex-start; margin-top: 20px">
                <input name="search" class="form-control" list="datalistOptions" id="searchBarID" style="display: flex; flex: 1; flex-direction:row; margin-bottom: 20px; " placeholder="Search for name or code ">
            </div>

        </div>

        <!-- Table for date -->
        <div id="dateTable" class="borrowedAndReturnedToday" style="display:flex; flex-direction: row; justify-content: space-between; margin-top: 30px;">

            <!-- Borrowed Today -->
            <div id="borrowedTodayID" class="borrowedToday" style="width: 700px; font-size: 70%; margin-right: 50px">
                <p style="font-size: 25px; color: #f0f0f0;">Borrowed Item</p>
                <table class="table table-striped table-hover">
                    <thead>
                        <th style="border-top-left-radius: 5px;">IMAGE</th>
                        <th>ITEM</th>
                        <th>BRAND</th>
                        <th>COLOR</th>
                        <th>QTY/PIRASO</th>
                        <th>LOCATION</th>
                        <th>DATE BORROWED</th>
                        <th>NAME OF BORROWER</th>
                        <th style="border-top-right-radius: 5px;">SIGNATURE</th>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($borrowedToday as $borrowed)
                        <tr style="height: 30px">
                            <td>
                                @if($borrowed->ITEM_IMAGE)
                                <img src="{{ asset($borrowed->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                                @else
                                <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                                @endif
                            </td>
                            <td>{{$borrowed->ITEM_CODE}} {{$borrowed->ITEM}}</td>
                            <td>{{$borrowed->BRAND}}</td>
                            <td>{{$borrowed->COLOR}}</td>
                            <td>{{$borrowed->QUANTITY}}</td>
                            <td>{{$borrowed->LOCATION}}</td>
                            <td>{{$borrowed->DATE_BORROWED}}</td>
                            <td>{{$borrowed->BORROWER}}</td>
                            <td>
                                @if($borrowed->BORROWER_SIGNATURE)
                                <img src="{{ asset($borrowed->BORROWER_SIGNATURE) }}" alt="borrower signature" style="width: 60px; height: 30px;" loading="lazy">
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Returned Today -->
            <div id="returnedTodayID" class="returnedToday" style="width: 700px; font-size: 70%; ">
                <p style="font-size: 25px; color: #f0f0f0;">Returned Item</p>
                <table class="table table-striped table-hover" >
                    <thead>
                        <th style="border-top-left-radius: 5px;">IMAGE</th>
                        <th>ITEM</th>
                        <th>BRAND</th>
                        <th>COLOR</th>
                        <th>QTY/PIRASO</th>
                        <th>LOCATION</th>
                        <th>DATE RETURNED</th>
                        <th>NAME OF RETURNEE</th>
                        <th style="border-top-right-radius: 5px;">SIGNATURE</th>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($returnedToday as $returned)
                        <tr style="height: 30px">
                            <td>
                                @if($returned->ITEM_IMAGE)
                                <img src="{{ asset($returned->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                                @else
                                <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                                @endif
                            </td>
                            <td>{{$returned->ITEM_CODE}} {{$returned->ITEM}}</td>
                            <td>{{$returned->BRAND}}</td>
                            <td>{{$returned->COLOR}}</td>
                            <td>{{$returned->QUANTITY}}</td>
                            <td>{{$returned->LOCATION}}</td>
                            <td>{{$returned->DATE_RETURNED}}</td>
                            <td>{{$returned->RETURNEE}}</td>
                            <td>
                                @if($returned->RETURNEE_SIGNATURE)
                                <img src="{{ asset($returned->RETURNEE_SIGNATURE) }}" alt="borrower signature" style="width: 60px; height: 30px;" loading="lazy">
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Table for equipment -->
        <div id="equipmentTable">
            <table class="table table-striped table-hover" style="font-size: 80%">
                <thead>
                    <th style="border-top-left-radius: 5px;">IMAGE</th>
                    <th>ITEM</th>
                    <th>BRAND</th>
                    <th>COLOR</th>
                    <th>QTY/PIRASO</th>
                    <th>LOCATION</th>
                    <th>DATE BORROWED</th>
                    <th>NAME OF BORROWER</th>
                    <th>DATE RETURNED</th>
                    <th>NAME OF RETURNEE</th>
                    <th style="border-top-right-radius: 5px;">SIGNATURE</th>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($searchEquipments as $search)
                    <tr style="height: 30px">
                        <td>
                            @if($search->ITEM_IMAGE)
                                <img src="{{ asset($search->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                                @else
                                <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                            @endif
                        </td>
                        <td>{{$search->ITEM_CODE}} {{$search->ITEM}}</td>
                        <td>{{$search->BRAND}}</td>
                        <td>{{$search->COLOR}}</td>
                        <td>{{$search->QUANTITY}}</td>
                        <td>{{$search->LOCATION}}</td>
                        <td>{{$search->DATE_BORROWED}}</td>
                        <td>{{$search->BORROWER}}</td>
                        <td>{{$search->DATE_RETURNED}}</td>
                        <td>{{$search->RETURNEE}}</td>
                        <td>{{$search->BORROWER_SIGNATURE}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

    </div>

</div>

@endsection