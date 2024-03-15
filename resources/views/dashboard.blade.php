<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Dashboard')

<!-- Pass the content to layout -->
@section('content')

<link href="{{asset('css/dashboardstyles.css')}}" rel="stylesheet">
<!-- Main Content -->
<div class="p-0" style="flex:1; background-color:#282828 ">
    <div class="somelittlebox">
        <div class="stats">
            Stats 1
        </div>
        <div class="stats">
            Stats 2
        </div>
        <div class="stats">
            Stats 3
        </div>
        <div class="stats">
            Stats 4
        </div>
    </div>
                    
    <div class="bigbox">
        <div class="bigstats">
            Chart 1
        </div>
        <div class="bigstats">
            Chart 2
        </div>
    </div>

    <div class="bigbox">
        <div class="bigstats">
            Chart 1
        </div>
        <div class="bigstats">
            Chart 2
        </div>
    </div>

    <div class="bigbox">
        <div class="bigstats">
            Chart 1
        </div>
        <div class="bigstats">
            Chart 2
        </div>
    </div>
         
</div>
@endsection