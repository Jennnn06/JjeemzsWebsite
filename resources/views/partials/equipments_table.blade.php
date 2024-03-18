<!-- Partial Table -->
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
        @foreach($equipments as $equipment)
            <tr>
                <td>{{$equipment ->id}}</td>
                <td>
                    @if ($equipment->ITEM_IMAGE)
                    <img src="{{$equipment->ITEM_IMAGE}}" alt="Equipment Image" style="width: 50px; height: 50px;">
                    @else
                    <img src="assets/placeholder.jpg" alt="Equipment Image" style="width: 50px; height: 50px;">
                    @endif
                </td>
                <td>{{$equipment ->ITEM_NAME}}</td>
                <td>{{$equipment ->BRAND}}</td>
                <td>{{$equipment ->COLOR}}</td>
                <td>{{$equipment ->QUANTITY}}</td>
                <td>{{$equipment ->STATUS}}</td>
                <td>{{$equipment ->AVAILABLE}}</td>
                <td>{{$equipment ->IN_OUT}}</td>
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
                    <a href="#" style="text-decoration: none">
                        <i class="fa-solid fa-xmark" style="width: 30px; height: 30px; border-radius: 5px; background-color: red; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>