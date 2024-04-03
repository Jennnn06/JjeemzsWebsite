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
<div class="d-flex flex-column" style="height:100vh; width: 210px; background-color: #323232; position: fixed; z-index: 1000;">
    <div class="logo" style="display:flex; justify-content: center; height:auto; width:auto; margin-top: 20px">
        <i class="fa-solid fa-building" style="color:#779933; font-size: 50px; text-align: center;"></i>
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto p-3">
    <li>
        <a href="{{route('dashboard')}}" class="nav-link{{ request()->routeIs('dashboard') ? ' active' : ' link-body-emphasis' }} customhover" style="margin: 10px 0 30px 0; {{ request()->routeIs('dashboard') ? 'background-color: #779933' : '' }}" >
            <i class="fa-solid fa-chart-line" style="margin-right: 5px;"></i>
        Dashboard
        </a>
    </li>
    <li>
        <a href="{{route('equipments')}}" class="nav-link{{ request()->routeIs('equipments') || request()->is('createfolder') || request()->routeIs('equipments.viewfolder') || request()->routeIs('equipments.editfolder') ? ' active' : ' link-body-emphasis' }} customhover" style="margin-bottom: 30px;  {{ request()->routeIs('equipments') || request()->is('createfolder') || request()->routeIs('equipments.viewfolder') || request()->routeIs('equipments.editfolder') ? 'background-color: #779933' : '' }}">
            <i class="fa-solid fa-toolbox" style="margin-right: 5px;"></i>
        Tools & Equipments
        </a>
    </li>
    <li>
        <a href="{{route('addequipments')}}" class="nav-link{{ request()->routeIs('addequipments') || request()->is('addequipments/add') || request()->routeIs('editequipments.edit') ? ' active' : ' link-body-emphasis' }} customhover" style="margin-bottom: 30px;  {{ request()->routeIs('addequipments') || request()->is('addequipments/add') || request()->routeIs('editequipments.edit') ? 'background-color: #779933' : '' }}">
            <i class="fa-solid fa-plus" style="margin-right: 5px;"></i>
        Add Tools & Equipments
        </a>
    </li>
    <li>
        <a href="{{route('loghistory')}}" class="nav-link link-body-emphasis customhover" style="margin-bottom: 30px;">
            <i class="fa-solid fa-book-open" style="margin-right: 5px;"></i>
        Log History
        </a>
    </li>
    @if(Auth::user()->id === 1)
        <li>
            <a href="{{route('manageusers')}}" class="nav-link{{ request()->routeIs('manageusers') || request()->routeIs('editusers') || request()->routeIs('createusers') ? ' active' : ' link-body-emphasis' }} customhover" style="margin-bottom: 30px; {{ request()->routeIs('manageusers') || request()->routeIs('editusers') || request()->routeIs('createusers') ? 'background-color: #779933' : '' }}">
                <i class="fa-solid fa-users" style="margin-right: 5px;"></i>
            Manage Users
            </a>
        </li>
    @endif
    <li>
        <a href="{{route('logout')}}" class="nav-link link-body-emphasis customhover logout-link">
            <i class="fa-solid fa-right-from-bracket" style="margin: 5px;"></i>
        Logout
        </a>
    </li>
    </ul>
</div>