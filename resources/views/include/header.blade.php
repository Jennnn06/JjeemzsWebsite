<!-- Navigation -->

<nav class="navbar sticky-top flex-md-nowrap p-0 " style="background-color: #323232; height:75px; color: #f0f0f0; margin-left: 20px; border-radius:5px;">    
    <div class="container-fluid">
        <p style="margin: 5px 0 0 5px; font-size:30px">
            @if(request()->routeIs('dashboard'))
                Dashboard
            @elseif(request()->routeIs('equipments') || request()->is('createfolder'))
                Equipments
            @elseif(request()->routeIs('addequipments') || request()->is('addequipments/add') || request()->routeIs('editequipments.edit'))
                Add Equipments
            @elseif(request()->routeIs('manageusers') || request()->routeIs('editusers') || request()->routeIs('createusers'))
                Manage Users
            @else
                Dashboard
            @endif
        </p> 
        <a href="" style="display:flex; text-decoration: none; color: #f0f0f0;">
            <p style="margin-top: 15px">
                Welcome back <b>@auth {{auth()->user()->name}} @endauth</b>!
                <i class="fa-solid fa-user"></i> </p>
        </a>         
      </div>
  </nav>