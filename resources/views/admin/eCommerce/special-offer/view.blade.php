<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b>Special Offer Full View Information</b>
</div>

<h4 class="text-center">Special Offer</h4>
<div class="table-responsive">
    <table class="table mb-3 table-bordered table-striped">
        <tr>
            <th class="text-center">Offer Name</th>
            <td class="text-center">{{ $model->name }} </td>
        </tr>
        <tr>
            <th class="text-center">Offer Sub Heading</th>
            <td class="text-center">{{ $model->sub_heading }} </td>
        </tr>
        <tr>
            <th class="text-center">Offer Status</th>
            <td class="text-center">
                @if ($model->status == 1)
                    <span class="badge badge-success">Active</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif    
            </td>
        </tr>
        <tr>
            <th class="text-center">Offer Cover Image</th>
            <td class="text-center"> <img src="{{ asset('storage/eCommerce/special_offer/'. $model->cover_image)}}" alt="Cover Image"></td>
        </tr>
    </table>
</div>

<h4 class="text-center">Special Offer Item</h4>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-info">
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Variation Name</th>
                <th>Discount Type</th>
                <th>Discount Amount</th>
                <th>Price Without Discount</th>
                <th>Price With Discount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $loop->index + 1}} </td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->variation->name }}</td>
                    <td>{{ $item->discount_type }}</td>
                    <td>{{ $item->discount_amount }}</td>
                    <td>{{ $item->price_without_dis }}</td>
                    <td>{{ $item->price_with_dis }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>