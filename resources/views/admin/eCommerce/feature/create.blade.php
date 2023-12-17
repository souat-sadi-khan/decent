<div class="card">
    <div class="card-header">
        <h4 class="text-center">Add New Feature Product In the Feature Product List</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Check</th>
                        <th>Imaage</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        @php
                            $find_price =  App\models\Production\Variation::where('product_id', $item->id)->get();
                            if(count($find_price) > 0) {
                                $total_product_variation = count($find_price);
                                $price = 0;
                                foreach($find_price as $row) {
                                    $default_price = $row['default_sell_price'];
                                    $price = $price + $default_price;
                                }
                        
                                $per_product_price = round($price / $total_product_variation) ;
                                
                            }
                        @endphp
                        <tr>
                            <td>
                                <input data-url="{{ route('admin.eCommerce.feature-product.change_status') }}" {{$item->feature_product_status == 1 ? 'checked' : ''}} type="checkbox" class="item" data-id="{{$item->id}}">
                            </td>
                            <td>
                                <img width="100px" src="{{$item->photo ? asset('storage/product/'.$item->photo) : 'http://placehold.it/215x215'}}">
                            </td>
                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                                {{($item->category->name)}}
                            </td>
                            <td>
                                ৳ {{$per_product_price}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function() {
        $(document).on('click', '.item', function() {
            var id = $(this).data('id');
            var url = $(this).data('url');
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    id: id
                },
                success: function (data) {
                    toastr.success(data.message);
                    
                    
                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 1000);
                    }
                }
            });
        });
    });
</script>
