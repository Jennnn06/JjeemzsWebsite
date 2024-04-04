<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Add Equipments')

<!-- Pass the content to layout -->
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- JavaScript AJAX Request for SEARCH BAR -->
<script>
    $(document).ready(function() {
        $('#searchEquipmentsBar, #filbybrand, #filbycolor').on('input', function() {
            var searchTerm = $('#searchEquipmentsBar').val();
            var brandFilter = $('#filbybrand').val();
            var colorFilter = $('#filbycolor').val();

            $.ajax({
                url: '{{ route('addequipments') }}', // Route to handle the search request on the server
                method: 'GET',
                data: { 
                    search: searchTerm,
                    brand: brandFilter,
                    color: colorFilter
                },
                success: function(response) {
                    $('#equipmentsTable').html(response); // Update the users table with search results
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Log any errors to the console
                }
            });
        });
    });
</script> 

<!-- Equipments -->
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828; min-height: 100vh;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px;">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">List of Tools & Equipments</p>
            <a href="{{ url('/addequipments/add') }}" style="height: 50px; width:200px; margin-bottom: 20px; border-radius: 5px; font-size: 15px; text-decoration: none; color: white; background-color: green; text-align: center; padding-top: 15px; ">
                Add Tools / Equipment
            </a>
        </div>

        <!-- Search bar 
        <form action="#"> 
        </form>-->
        <div style="display: flex; flex-direction: row;">

            <!-- Searchbar -->
            <div style="align-items: flex-start">
                <label for="searchEquipmentsBar" class="form-label" style="color: #f0f0f0; ">Select an equipment/tools</label>
                <input name="search" class="form-control" list="datalistOptions" id="searchEquipmentsBar" style="display: flex; flex: 1; flex-direction:row; margin-bottom: 20px; width: 500px" placeholder="Search for name, code or serial number...">
            </div>
            
            <!-- Filter by brand -->
            <div style="align-items: flex-start">
                <label for="filbybrand" class="form-label" style="color: #f0f0f0; margin-left: 50px">Filter by brand</label>
                <select class="form-select form-select-sm" aria-label="Small select example" id="filbybrand" style="width: 200px; margin-left: 50px; ">
                    <option selected>-- Filter by brand --</option>
                    @foreach($brands as $brand)
                        <option value="{{$brand}}">{{$brand}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by color -->
            <div style="align-items: flex-start">
                <label for="filbycolor" class="form-label" style="color: #f0f0f0; margin-left: 50px">Filter by color</label>
                <select class="form-select form-select-sm" aria-label="Small select example" id="filbycolor" style="width: 200px; margin-left: 50px; ">
                    <option selected>-- Filter by color --</option>
                    @foreach($colors as $color)
                        <option value="{{$color}}">{{$color}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Table -->
        <div id="equipmentsTable">
            <table class="table table-striped table-hover" style="font-size: 70%">
                <thead>
                    <th style="border-top-left-radius: 5px;">IMAGE</th>
                    <th>CODE</th>
                    <th>SERIAL</th>
                    <th>NAME</th>
                    <th>BRAND</th>
                    <th>COLOR</th>
                    <th>QTY</th>
                    <th>STATUS</th>
                    <th>AVAILABILITY</th>
                    <th>BORROWEDBY</th>
                    <th>LOCATION</th>
                    <th>REASON</th>
                    <th>NOTE</th>
                    <th>FOLDER</th>
                    <th>EDIT</th>
                    <th style="border-top-right-radius: 5px;">Delete</th>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($equipments as $equipment)
                        <tr>
                            <!--Image -->
                            <td>
                                @if ($equipment->ITEM_IMAGE)
                                <img src="{{ asset($equipment->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                                @else
                                <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                                @endif
                            </td>
                            <th>{{$equipment ->ITEM_CODE}}</th>
                            <th>{{$equipment ->ITEM_SERIAL_NUMBER}}</th>
                            <td>{{$equipment ->ITEM_NAME}}</td>
                            <td>{{$equipment ->BRAND}}</td>
                            <td>{{$equipment ->COLOR}}</td>
                            <td>{{$equipment ->QUANTITY}}</td>
                            <td>{{$equipment ->STATUS}}</td>
                            <td>{{$equipment ->AVAILABLE}}</td>
                            <td>{{$equipment ->BORROWED_BY}}</td>
                            <td>{{$equipment ->LOCATION}}</td>
                            <td>{{$equipment ->REASON}}</td>
                            <td>{{$equipment ->NOTE}}</td>
                            <td>{{$equipment ->FOLDER}}</td>

                            <!-- Edit Equipment -->
                            <td>
                                <!-- view -> web.php/route -> controller -->
                                <a href="{{route('editequipments.edit', ['id' => $equipment->id])}}" style="text-decoration: none">
                                    @csrf
                                    <i class="fa-solid fa-pencil" style="width: 30px; height: 30px; border-radius: 5px; background-color: green; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center">
                                    </i>
                                </a>
                            </td>

                            <!-- Delete -->
                            <td>
                                <form id="deleteEquipmentForm_{{ $equipment->id }}" method="POST" action="{{ route('addequipments.delete', ['equipment' => $equipment->id]) }}" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: transparent; border: none; cursor: pointer;">
                                        <i class="fa-solid fa-xmark" style="width: 30px; height: 30px; border-radius: 5px; background-color: red; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center"></i>
                                    </button>
                                </form>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection