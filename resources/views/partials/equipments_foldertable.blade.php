<link href="{{asset('css/equipmentstyles.css')}}" rel="stylesheet">

<!-- Folder -->
<div class="boxes" id="boxes">
    @foreach ($equipments as $index => $equipment)
    <div class="box">
        <!-- ID, Edit and View-->
        <div class="column1">

            <!-- ID -->
            <div class="id">
                <p style="margin-top: 30px; margin-left: 15px">ID CODE: {{$equipment->id}}</p>
            </div>

            <!-- Edit -->
            <div class="edit">
                <!-- Creates 'id' variable the comes from $equipment->id(got declared from controller) -->
                <a href="{{ route('equipments.editfolder', ['id' => $equipment->id]) }}" style="text-decoration: none; color: white;">
                    <i class="fa-solid fa-pencil">
                    </i>
                </a>
            </div>

            <!-- View -->
            <div class="view">
                <a href="{{ route('equipments.viewfolder', ['id' => $equipment->id]) }}">
                    <i class="fa-solid fa-eye" style="color: white"></i>
                </a>                        
            </div>
            
        </div>
        <div class="column4">
            @if ($equipment->equipmentsimage)
                <img src="{{$equipment->equipmentsimage}}" alt="Equipment Image" style="width: 90px; height: 90px;" loading="lazy">
            @else
                <p>No image available</p>
            @endif
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