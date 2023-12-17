@forelse($products as $product)
	<div class="col-md-4 col-xs-4 product_list no-print my-2">
		<div class="product_box bg-white add_product border-0 rounded" data-toggle="tooltip" data-qty="1" data-url="{{ route('admin.sale.get_variation_product') }}" data-placement="bottom" data-variation_id="{{$product->variation_id}}" title="{{$product->name}}">
		<div class="image-container">
			<img src="{{asset('no-product-image.jpg') }}" alt="" width="50">
		</div>
			<div class="text text-dark text-uppercase">
				<small class="font-weight-bold">Products
					- {{$product->variation}}
				</small>
			</div>
			<small class="text-dark font-weight-bold">
				({{$product->sub_sku}})
			</small>
		</div>
	</div>
@empty
	<input type="hidden" id="no_products_found">
	<div class="col-md-12">
		<h4 class="text-center">
			{{ _lang('No Product Found') }}
		</h4>
	</div>
@endforelse
