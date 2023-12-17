@foreach ($models as $model)
                @php
                $product = App\models\Production\Product::with('photo_details', 'variation')->findOrFail($model->attributes->product_id);
                $variation = App\models\Production\Variation::findOrFail($model->id);
                @endphp
                <div class="row border">
                    <div class="col-xs-12 col-sm-2">
                        <div class="img-holder">
                            <img src="{{$product->photo?asset('storage/product/'.$product->photo):'http://placehold.it/105x105'}}"
                                alt="image description">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <strong class="product-name">{{$model->name}}</strong>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <strong class="product-name">{{$variation->name}}</strong>
                    </div>
                    <div class="col-xs-12 col-sm-1">
                        <strong class="price">{{get_option('currency')}} {{$model->price}}</strong>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <div action="#" class="qyt-form">
                            <fieldset>
                                <input type="hidden" class="cart-id" id="cart-id" value="{{$model->id}}">
                                <input type="number" data-url="{{route('shopping-cart-qty')}}"
                                    class="form-control cart-qty" id="cart-qty" value="{{$model->quantity}}">
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <strong class="price">{{get_option('currency')}} {{($model->price)*($model->quantity)}}</strong>
                        <a data-url="{{route('shopping-cart-remove')}}" class="remove" id="remove"><i
                                class="fa fa-close"></i></a>
                    </div>
                </div>
                @endforeach