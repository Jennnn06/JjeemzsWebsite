<style>
    .customhover{
        color: #969696 !important;
    }

    .active{
        color: #f0f0f0 !important;
    }

    .customhover:hover{
        background-color: #779933;
        color: #f0f0f0 !important;
    }

    .logout-link {
        position: fixed;
        width: 185px;
        bottom: 20px; /* Adjust as needed */
        left: 10px; /* Adjust as needed */
    }

    @media (max-height: 480px) {
        .logout-link {
            position: relative;
            bottom: auto;
            left: auto;
        }
    }
    
</style>

<!-- Sidebar -->
<div class="d-flex flex-column position-fixed" style="height:100vh; width: 210px; background-color: #323232;">
    <div class="logo" style="background-color: #779933; width: 100%">
        <img src="{{asset('img/logosample.png')}}" style="width: 100px; height: 75px; display: block; margin: 0 auto;">
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto p-3">
    <li>
        <a href="{{route('dashboard')}}" class="nav-link{{ request()->routeIs('dashboard') ? ' active' : ' link-body-emphasis' }} customhover" style="margin: 10px 0 30px 0; {{ request()->routeIs('dashboard') ? 'background-color: #779933' : '' }}" >
            <i class="fa-solid fa-chart-line" style="margin-right: 5px;"></i>
        Dashboard
        </a>
    </li>
    <li>
        <a href="{{route('equipments')}}" class="nav-link{{ request()->routeIs('equipments') ? ' active' : ' link-body-emphasis' }} customhover" style="margin-bottom: 30px;  {{ request()->routeIs('equipments') ? 'background-color: #779933' : '' }}">
            <i class="fa-solid fa-toolbox" style="margin-right: 5px;"></i>
        Equipments
        </a>
    </li>
    <li>
        <a href="{{route('addequipments')}}" class="nav-link{{ request()->routeIs('addequipments') ? ' active' : ' link-body-emphasis' }} customhover" style="margin-bottom: 30px;  {{ request()->routeIs('addequipments') ? 'background-color: #779933' : '' }}">
            <i class="fa-solid fa-plus" style="margin-right: 5px;"></i>
        Add Equipments
        </a>
    </li>
    <li>
        <a href="{{route('manageusers')}}" class="nav-link{{ request()->routeIs('manageusers') || request()->routeIs('editusers') ? ' active' : ' link-body-emphasis' }} customhover" style="margin-bottom: 30px; {{ request()->routeIs('manageusers') || request()->routeIs('editusers') ? 'background-color: #779933' : '' }}">
            <i class="fa-solid fa-users" style="margin-right: 5px;"></i>
        Manage Users
        </a>
    </li>
    <li>
        <a href="{{route('logout')}}" class="nav-link link-body-emphasis customhover logout-link">
            <i class="fa-solid fa-right-from-bracket" style="margin: 5px;"></i>
        Logout
        </a>
    </li>
    </ul>
</div>