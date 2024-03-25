<!-- Navigation -->

<nav class="navbar flex-md-nowrap p-0 " style="background-color: #9e9c9c; height:75px; color: #f0f0f0; margin-left: 20px; border-bottom-left-radius:5px; border-bottom-right-radius:5px; position: sticky; z-index: 999;">    
    <div class="container-fluid">
        <p style="margin: 5px 0 0 5px; font-size:30px">
            @if(request()->routeIs('dashboard'))
                <img src="assets/bg.png" style="width: 150px; height: 100px;"> JJEEMZS Constructions Services
                </img>
            @elseif(request()->routeIs('equipments') || request()->is('createfolder') || request()->routeIs('equipments.viewfolder') || request()->routeIs('equipments.editfolder') )
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