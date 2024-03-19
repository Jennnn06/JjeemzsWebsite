<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Dashboard')

<!-- Pass the content to layout -->
@section('content')

<link href="{{asset('css/dashboardstyles.css')}}" rel="stylesheet">

<!-- Main Content -->
<div class="p-0" style="flex-direction: row; flex:1; background-color:#282828 ">

    <!--User-->
    <div class="somelittlebox">
        <div style="display: flex; flex-direction:row;">
            <div style="display:flex; align-items: center; justify-content:center; width: 50px; height: 110px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; background-color: lightsalmon">
                <i class="fa-solid fa-user" style="font-size: 30px; color: white"></i>
            </div>
            <div class="stats" style="background-color: #323232;">
                <p style="display: flex; justify-content: center; margin-top: 5px">Total User</p>
                <p style="display: flex; justify-content: center; font-size: 40px; margin-top: -10px">{{$totalRowsOfUser}}</p>
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
                <p style="display: flex; justify-content: center; margin-top: 5px">Broken Equipments</p>
                <p style="display: flex; justify-content: center; font-size: 40px; margin-top: -10px">{{$brokenCount}}</p>
            </div>
        </div>

    </div>
                    
    <div class="bigbox">
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
                                <img src="{{ $maintenance->ITEM_IMAGE }}" alt="{{ $maintenance->ITEM_NAME }}" style="width: 50px; height: 50px;">
                            </td>
                            <td>{{ $maintenance->ITEM_NAME }}</td>
                            <td>{{ $maintenance->updated_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bigstats calendar">
            <div id="day" style="margin: 10px; font-size: 20px">Wednesday</div>
            <div id="calendar">
                <div id="month">month</div>
                <div id="date">date</div>
            </div>
            <div id="year" style="margin: 10px; font-size: 20px">year</div>
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