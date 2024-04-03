<!-- Table -->
<div id="equipmentsTable">
    <table class="table table-striped table-hover" style="font-size: 70%">
        <thead>
            <th style="border-top-left-radius: 5px;">IMAGE</th>
            <th>CODE</th>
            <th>SERIAL</th>
            <th>NAME</th>
            <th>BRAND</th>
            <th>COLOR</th>
            <th>QTY</th>
            <th>STATUS</th>
            <th>AVAILABILITY</th>
            <th>BORROWEDBY</th>
            <th>LOCATION</th>
            <th>REASON</th>
            <th>NOTE</th>
            <th>FOLDER</th>
            <th>EDIT</th>
            <th style="border-top-right-radius: 5px;">DELETE</th>
        </thead>
        <tbody class="table-group-divider">
            @foreach($equipmentsView as $equipment)
                <tr>
                    <!--Image -->
                    <td>
                        @if ($equipment->ITEM_IMAGE)
                        <img src="{{ asset($equipment->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                        @else
                        <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                        @endif
                    </td>
                    <th>{{$equipment ->ITEM_CODE}}</th>
                    <th>{{$equipment ->ITEM_SERIAL_NUMBER}}</th>
                    <td>{{$equipment ->ITEM_NAME}}</td>
                    <td>{{$equipment ->BRAND}}</td>
                    <td>{{$equipment ->COLOR}}</td>
                    <td>{{$equipment ->QUANTITY}}</td>
                    <td>{{$equipment ->STATUS}}</td>
                    <td>{{$equipment ->AVAILABLE}}</td>
                    <td>{{$equipment ->BORROWED_BY}}</td>
                    <td>{{$equipment ->LOCATION}}</td>
                    <td>{{$equipment ->REASON}}</td>
                    <td>{{$equipment ->NOTE}}</td>
                    <td>{{$equipment ->FOLDER}}</td>

                    <!-- Edit Equipment -->
                    <td>
                        <!-- view -> web.php/route -> controller -->
                        <a href="{{route('editequipments.edit', ['id' => $equipment->id])}}" style="text-decoration: none">
                            @csrf
                            <i class="fa-solid fa-pencil" style="width: 30px; height: 30px; border-radius: 5px; background-color: green; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center">
                            </i>
                        </a>
                    </td>

                    <!-- Delete -->
                    <td>
                        <form id="deleteEquipmentForm_{{ $equipment->id }}" method="POST" action="{{ route('addequipments.delete', ['equipment' => $equipment->id]) }}" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: transparent; border: none; cursor: pointer;">
                                <i class="fa-solid fa-xmark" style="width: 30px; height: 30px; border-radius: 5px; background-color: red; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center"></i>
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>