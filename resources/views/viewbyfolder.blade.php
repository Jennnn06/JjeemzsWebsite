<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'View')

<!-- Pass the content to layout -->
@section('content')

<!-- jQuery CDN (if not already included) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JavaScript AJAX Request for SEARCH BAR -->
<script>
    $(document).ready(function() {
        $('#searchUserBar').on('input', function() {
            var searchTerm = $(this).val(); // Get the search query from the input field
            $.ajax({
                url: '{{ route('addequipments') }}', // Route to handle the search request on the server
                method: 'GET',
                data: { search: searchTerm }, // Pass the search query as data
                success: function(response) {
                    $('#equipmentsTable').html(response); // Update the users table with search results
                }
            });
        });
    });
</script> 

<!-- Equipments -->
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828; min-height:100vh;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; min-height:100vh;">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">List of Equipments</p>
            <a href="{{ url('/addequipments/add') }}" style="height: 50px; width:150px; margin-bottom: 20px; border-radius: 5px; font-size: 15px; text-decoration: none; color: white; background-color: green; text-align: center; padding-top: 15px; ">
                Add Equipment
            </a>
        </div>

        <!-- Search bar 
        <form action="#"> 
        </form>-->
        <input name="search" class="form-control" list="datalistOptions" id="searchUserBar" style="display: flex; flex: 1; flex-direction:row; margin-bottom: 20px" placeholder="Type to search...">
        

        <!-- Table -->
        <div id="equipmentsTable">
            <table class="table table-striped table-hover" >
                <thead>
                    <th style="border-top-left-radius: 5px;">IMAGE</th>
                    <th>ITEM NAME</th>
                    <th>BRAND</th>
                    <th>COLOR</th>
                    <th>QTY</th>
                    <th>STATUS</th>
                    <th>AVAILABLE</th>
                    <th>IN / OUT</th>
                    <th>REASON</th>
                    <th>NOTE</th>
                    <th>FOLDER</th>
                    <th>Edit</th>
                    <th style="border-top-right-radius: 5px;">Delete</th>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($equipmentsView as $equipment)
                        <tr>
                            <!--Image -->
                            <td>
                                @if ($equipment->ITEM_IMAGE)
                                    <img src="{{ asset($equipment->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 50px; height: 50px;">
                                @else
                                    <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 50px; height: 50px;">
                                @endif
                            </td>
                            <td>{{$equipment ->ITEM_NAME}}</td>
                            <td>{{$equipment ->BRAND}}</td>
                            <td>{{$equipment ->COLOR}}</td>
                            <td>{{$equipment ->QUANTITY}}</td>
                            <td>{{$equipment ->STATUS}}</td>
                            <td>{{$equipment ->AVAILABLE}}</td>
                            <td>{{$equipment ->IN_OUT}}</td>
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