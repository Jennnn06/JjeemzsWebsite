<!-- Table for equipment -->
<div id="equipmentTable">
    <table class="table table-striped table-hover" style="font-size: 80%">
        <thead>
            <th style="border-top-left-radius: 5px;">IMAGE</th>
            <th>ITEM</th>
            <th>BRAND</th>
            <th>COLOR</th>
            <th>QTY/PIRASO</th>
            <th>LOCATION</th>
            <th>DATE BORROWED</th>
            <th>NAME OF BORROWER</th>
            <th>DATE RETURNED</th>
            <th>NAME OF RETURNEE</th>
            <th style="border-top-right-radius: 5px;">SIGNATURE</th>
        </thead>
        <tbody class="table-group-divider">
            @foreach($searchEquipments as $search)
            <tr style="height: 30px">
                <td>
                    @if($search->ITEM_IMAGE)
                        <img src="{{ asset($search->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                        @else
                        <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                    @endif
                </td>
                <td>{{$search->ITEM_CODE}} {{$search->ITEM}}</td>
                <td>{{$search->BRAND}}</td>
                <td>{{$search->COLOR}}</td>
                <td>{{$search->QUANTITY}}</td>
                <td>{{$search->LOCATION}}</td>
                <td>{{$search->DATE_BORROWED}}</td>
                <td>{{$search->BORROWER}}</td>
                <td>{{$search->DATE_RETURNED}}</td>
                <td>{{$search->RETURNEE}}</td>
                <td>{{$search->BORROWER_SIGNATURE}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>