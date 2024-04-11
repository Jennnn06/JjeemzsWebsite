<!-- Returned Today -->
<div class="returnedToday" style="width: 700px;">
    <p style="font-size: 25px; color: #f0f0f0;">Returned Item</p>
    <table class="table table-striped table-hover" >
        <thead>
            <th style="border-top-left-radius: 5px;">IMAGE</th>
            <th>ITEM</th>
            <th>BRAND</th>
            <th>COLOR</th>
            <th>QTY/PIRASO</th>
            <th>LOCATION</th>
            <th>DATE RETURNED</th>
            <th>NAME OF RETURNEE</th>
            <th style="border-top-right-radius: 5px;">SIGNATURE</th>
        </thead>
        <tbody class="table-group-divider">
            @foreach($returnedToday as $returned)
            <tr style="height: 30px">
                <td>
                    @if($returned->ITEM_IMAGE)
                    <img src="{{ asset($returned->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                    @else
                    <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                    @endif
                </td>
                <td>{{$returned->ITEM_CODE}} {{$returned->ITEM}}</td>
                <td>{{$returned->BRAND}}</td>
                <td>{{$returned->COLOR}}</td>
                <td>{{$returned->QUANTITY}}</td>
                <td>{{$returned->LOCATION}}</td>
                <td>{{$returned->DATE_RETURNED}}</td>
                <td>{{$returned->RETURNEE}}</td>
                <td>
                    @if($returned->RETURNEE_SIGNATURE)
                    <img src="{{ asset($returned->RETURNEE_SIGNATURE) }}" alt="borrower signature" style="width: 60px; height: 30px;" loading="lazy">
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>