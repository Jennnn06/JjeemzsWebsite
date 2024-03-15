<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Add Equipments')

<!-- Pass the content to layout -->
@section('content')

<!-- Equipments -->
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; height:100vh">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">List of Equipments</p>
            <a href="{{ url('/addequipments/add') }}" style="height: 50px; width:150px; margin-bottom: 20px; border-radius: 5px; font-size: 15px; text-decoration: none; color: white; background-color: green; text-align: center; padding-top: 15px; ">
                Add Equipment
            </a>
        </div>

        <!-- Search bar -->
        <form action="#">
            <input name="search" class="form-control" list="datalistOptions" id="searchUserBar" style="display: flex; flex: 1; flex-direction:row; margin-bottom: 20px" placeholder="Type to search...">
        </form>

        <!-- Table -->
        <div id="usersTable">
            <table class="table table-striped table-hover" >
                <thead>
                    <th style="border-top-left-radius: 5px;">ID</th>
                    <th>IMAGE</th>
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
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection