<!-- Borrowed Today -->
<div id="borrowedTodayID" class="borrowedToday" style="width: 700px; margin-right: 50px">
    <p style="font-size: 25px; color: #f0f0f0;">Borrowed Item</p>
    <table class="table table-striped table-hover">
        <thead>
            <th style="border-top-left-radius: 5px;">IMAGE</th>
            <th>ITEM</th>
            <th>BRAND</th>
            <th>COLOR</th>
            <th>QTY/PIRASO</th>
            <th>LOCATION</th>
            <th>DATE BORROWED</th>
            <th>NAME OF BORROWER</th>
            <th style="border-top-right-radius: 5px;">SIGNATURE</th>
        </thead>
        <tbody class="table-group-divider">
            @foreach($borrowedToday as $borrowed)
            <tr style="height: 30px">
                <td>
                    @if($borrowed->ITEM_IMAGE)
                    <img src="{{ asset($borrowed->ITEM_IMAGE) }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                    @else
                    <img src="{{ asset('assets/placeholder.jpg') }}" alt="Equipment Image" style="width: 60px; height: 55px;" loading="lazy">
                    @endif
                </td>
                <td>{{$borrowed->ITEM_CODE}} {{$borrowed->ITEM}}</td>
                <td>{{$borrowed->BRAND}}</td>
                <td>{{$borrowed->COLOR}}</td>
                <td>{{$borrowed->QUANTITY}}</td>
                <td>{{$borrowed->LOCATION}}</td>
                <td>{{$borrowed->DATE_BORROWED}}</td>
                <td>{{$borrowed->BORROWER}}</td>
                <td>
                    @if($borrowed->BORROWER_SIGNATURE)
                    <img src="{{ asset($borrowed->BORROWER_SIGNATURE) }}" alt="borrower signature" style="width: 60px; height: 30px;" loading="lazy">
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>