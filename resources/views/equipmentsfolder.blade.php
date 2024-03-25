<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Equipments')

<!-- Pass the content to layout -->
@section('content')

<link href="{{asset('css/equipmentstyles.css')}}" rel="stylesheet">

<!-- jQuery CDN (if not already included) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JavaScript AJAX Request for SEARCH BAR -->
<script>
    $(document).ready(function() {
    $('#searchEquipmentsFolderBar').on('input', function() {
        var searchTerm = $(this).val();
        $.ajax({
            url: '{{ route('equipments') }}',
            method: 'GET',
            data: { 
                search: searchTerm 
            },
            success: function(response) {
                $('#boxes').html(response);
            }
        });
    });
});

</script> 

<!-- Equipments -->
<div class="p-0" style="display: flex; flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; ">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Select an equipment/tools to check record of maintenance</p>
            <a href="{{route('createfolder')}}" style="height: 50px; width:150px; margin-bottom: 20px; border-radius: 5px; font-size: 15px; text-decoration: none; color: white; background-color: green; text-align: center; padding-top: 15px; ">
                Create New Folder
            </a>
        </div>
        
        <!-- Search containers -->
        <div>
            <!-- Search -->
            <div style="align-items: flex-start">
                <label for="exampleDataList" class="form-label" style="color: #f0f0f0;">Select an equipment/tools</label>
                <input name="search" class="form-control" list="datalistOptions" id="searchEquipmentsFolderBar"  placeholder="Type to search...">
            </div>
        </div>

        <!-- Folder -->
        <div class="boxes" id="boxes">
            @foreach ($equipments as $index => $equipment)
            <div class="box">
                <!-- ID, Edit and View-->
                <div class="column1">

                    <!-- ID -->
                    <div class="id">
                        <p style="margin-top: 30px; margin-left: 15px">ID CODE: {{$equipment->id}}</p>
                    </div>

                    <!-- Edit -->
                    <div class="edit">
                        <!-- Creates 'id' variable the comes from $equipment->id(got declared from controller) -->
                        <a href="{{ route('equipments.editfolder', ['id' => $equipment->id]) }}" style="text-decoration: none; color: white;">
                            <i class="fa-solid fa-pencil">
                            </i>
                        </a>
                    </div>

                    <!-- View -->
                    <div class="view">
                        <a href="{{ route('equipments.viewfolder', ['id' => $equipment->id]) }}">
                            <i class="fa-solid fa-eye" style="color: white"></i>
                        </a>                        
                    </div>
                    
                </div>
                <div class="column4">
                    @if ($equipment->equipmentsimage)
                        <img src="{{$equipment->equipmentsimage}}" alt="Equipment Image" style="width: 90px; height: 90px;" loading="lazy">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                <!-- Date Maintenance -->
                <div class="column2">
                    <p>Last Maintenance: {{$equipment->updated_at}}</p>
                </div>

                <!-- Equipment title -->
                <div class="column3">
                    <p>{{$equipment->equipmentsname}}</p>
                </div>
            </div>
                @if (($index + 1) % 3 == 0)
                <div class="clearfix"></div>
                @endif
            @endforeach
        </div>
        
        
            
    </div>
</div>
@endsection