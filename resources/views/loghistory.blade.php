<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Log History')

<!-- Pass the content to layout -->
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828; min-height: 100vh;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px;">
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Log History</p>
            <a href="{{ url('/addequipments/add') }}" style="height: 50px; width:150px; margin-bottom: 20px; border-radius: 5px; font-size: 15px; text-decoration: none; color: white; background-color: green; text-align: center; padding-top: 15px; ">
                Add Equipment
            </a>
        </div>
    </div>


</div>

@endsection