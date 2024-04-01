<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Dashboard')

<!-- Pass the content to layout -->
@section('content')

<link href="{{asset('css/dashboardstyles.css')}}" rel="stylesheet">

<!-- Main Content -->
<div class="p-0" style="flex-direction: row; flex:1; background-color:#282828 ">
    
    <p style="font-size: 30px; color: white; margin-left: 20px; margin-top: 30px">Dashboard</p>

    <!--Calendar-->
    <div class="somelittlebox">
        <div style="display: flex; flex-direction:row;">
            <div style="display:flex; align-items: center; justify-content:center; width: 50px; height: 110px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; background-color: lightsalmon">
                <i class="fa-regular fa-calendar-days" style="font-size: 30px; color: white"></i>
            </div>
            <div class="stats" style="background-color: #323232;">
                <p style="display: flex; justify-content: center;">
                    <div style="display: flex; flex-direction: row; justify-content: center; font-size: 20px">
                        <div>Today is</div>
                        <div id="day">Wednesday</div>
                    </div>
                </p>
                <p style="display: flex; justify-content: center; font-size: 40px; margin-top: -25px">
                    <div style="display: flex; flex-direction: row; justify-content: center; font-size: 20px">
                        <div id="month" style="margin-right: -5px">month</div>
                        <div id="date" style="margin-right: 1px">date</div>
                        <div style="margin-right: -5px">,</div>
                        <div id="year">year</div> 
                    </div>
                </p>
            </div>
        </div>

        <!--Folder-->
        <div style="display: flex; flex-direction:row;">
            <div style="display:flex; align-items: center; justify-content:center; width: 50px; height: 110px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; background-color: lightblue">
                <i class="fa-solid fa-folder" style="font-size: 30px; color: white"></i>
            </div>
            <div class="stats" style="background-color: #323232;">
                <p style="display: flex; justify-content: center; margin-top: 5px">Total Folder</p>
                <p style="display: flex; justify-content: center; font-size: 40px; margin-top: -10px">{{$totalRowsOfFolders}}</p>
            </div>
        </div>

        <!--Equipments-->
        <div style="display: flex; flex-direction:row;">
            <div style="display:flex; align-items: center; justify-content:center; width: 50px; height: 110px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; background-color: darkblue">
                <i class="fa-solid fa-helmet-safety" style="font-size: 30px; color: white"></i>
            </div>
            <div class="stats" style="background-color: #323232;">
                <p style="display: flex; justify-content: center; margin-top: 5px">Total Equipments</p>
                <p style="display: flex; justify-content: center; font-size: 40px; margin-top: -10px">{{$totalRowsOfEquipments}}</p>
            </div>
        </div>

        <!--Broken Equipments-->
        <div style="display: flex; flex-direction:row;">
            <div style="display:flex; align-items: center; justify-content:center; width: 50px; height: 110px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; background-color: lightgreen">
                <i class="fa-solid fa-screwdriver-wrench" style="font-size: 30px; color: white"></i>
            </div>
            <div class="stats" style="background-color: #323232;">
                <p style="display: flex; justify-content: center; margin-top: 5px">For Repair</p>
                <p style="display: flex; justify-content: center; font-size: 40px; margin-top: -10px">{{$forRepairCount}}</p>
            </div>
        </div>

    </div>
                    
    <div class="bigbox">

        <div class="activeusers">
            <p style="display: flex; justify-content: center; margin-top: 5px; font-size: 20px">Users</p>
            <div style="margin: 10px;">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Time Active</th>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($usersTable as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->ACTIVE_STATUS}}</td>
                            <td>{{$user->ACTIVE_LOCATION}}</td>
                            <td>{{$user->TIME_ACTIVE}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bigstats maint">
            <p style="display: flex; justify-content: center; margin-top: 5px; font-size: 20px">Latest Maintenance</p>
            <div id="table" style="margin: 10px;">
                <table class="table table-striped table-hover" >
                    <thead>
                        <th>Image</th>
                        <th>Equipments</th>
                        <th>Latest Maintenance</th>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($latestMaintenances as $maintenance)
                        <tr>
                            <td>
                                @if ($maintenance->ITEM_IMAGE)
                                <img src="{{ $maintenance->ITEM_IMAGE }}" alt="{{ $maintenance->ITEM_NAME }}" style="width: 50px; height: 50px;" loading="lazy">
                                @else
                                <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 50px; height: 50px;" loading="lazy">
                                @endif
                            </td>
                            <td>{{ $maintenance->ITEM_NAME }}</td>
                            <td>{{ \Carbon\Carbon::parse($maintenance->updated_at)->format('m-d-Y h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        // Get current date
        var currentDate = new Date();
    
        // Get month, date, and year
        var month = currentDate.toLocaleString('default', { month: 'long' });
        var date = currentDate.getDate();
        var day = currentDate.toLocaleString('default', { weekday: 'long' });
        var year = currentDate.getFullYear();
    
        // Update calendar elements
        document.getElementById('month').textContent = month;
        document.getElementById('date').textContent = date;
        document.getElementById('day').textContent = day;
        document.getElementById('year').textContent = year;
    </script>
         
</div>
@endsection