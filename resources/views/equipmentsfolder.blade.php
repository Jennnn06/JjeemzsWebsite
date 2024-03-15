<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Equipments')

<!-- Pass the content to layout -->
@section('content')

<link href="{{asset('css/equipmentstyles.css')}}" rel="stylesheet">


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
        <div style="display: flex; flex-direction: row;">

            <!-- Search -->
            <div style="align-items: flex-start">
                <label for="exampleDataList" class="form-label" style="color: #f0f0f0;">Select an equipment/tools</label>
                <input class="form-control" list="datalistOptions" id="exampleDataList" style="width:500px;" placeholder="Type to search...">
            </div>

            <!-- Filter by brand -->
            <div style="align-items: flex-start">
                <label for="filbybrand" class="form-label" style="color: #f0f0f0; margin-left: 50px">Filter by brand</label>
                <select class="form-select form-select-sm" aria-label="Small select example" id="filbybrand" style="width: 200px; margin-left: 50px; ">
                    <option selected>-- Filter by brand --</option>
                </select>
            </div>

            <!-- Filter by color -->
            <div style="align-items: flex-start">
                <label for="filbybrand" class="form-label" style="color: #f0f0f0; margin-left: 50px">Filter by color</label>
                <select class="form-select form-select-sm" aria-label="Small select example" id="filbybrand" style="width: 200px; margin-left: 50px; ">
                    <option selected>-- Filter by color --</option>
                </select>
            </div>


        </div>

        <!-- Folder -->
        <div class="boxes">
            @foreach ($equipments as $index => $equipment)
            <div class="box">
                <!-- ID, Edit, and View -->
                <div class="column1">
                    <div class="id">
                        <p style="margin-top: 30px; margin-left: 15px">ID CODE: {{$equipment->id}}</p>
                    </div>
                    <div class="edit">
                        <i class="fa-solid fa-pencil"></i>
                    </div>
                    <div class="view">
                        <i class="fa-solid fa-eye"></i>
                    </div>
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