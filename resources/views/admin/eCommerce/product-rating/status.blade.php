<div class="card">
    <div class="card-header">
        <h6>{{_lang('View Product Rating - ')}} </h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.product-rating.status_change', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                {{-- Rating --}}
                <div class="col-md-6 form-group">
                    <label for="rating">Rating</label>
                    <select name="rating" id="rating" class="form-control select" required> 
                        <option {{ $model->rating == 1 ? 'selected' : ''}} value="1">1</option>
                        <option {{ $model->rating == 2 ? 'selected' : ''}} value="2">2</option>
                        <option {{ $model->rating == 3 ? 'selected' : ''}} value="3">3</option>
                        <option {{ $model->rating == 4 ? 'selected' : ''}} value="4">4</option>
                        <option {{ $model->rating == 5 ? 'selected' : ''}} value="5">5</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>{{_lang('Select Status')}} <span class="text-danger">*</span></label>
                    <select required data-placeholder="Select Status" name="status" class="form-control select">
                        <option value="1" {{$model->status == '1'?'selected':''}}>Active</option>
                        <option value="0" {{$model->status == '0'?'selected':''}}>InActive</option>
                    </select>
                </div>

                {{-- Select Status --}}
                <div class="form-group col-md-12">
                    <label>{{_lang('Rating Comment:')}} </label> <br>
                    <textarea name="comment" id="comment" cols="30" rows="2" class="form-control">{{$model->comment}}</textarea>
                </div>
                     
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary" id="submit">{{_lang('Save')}}<i
                                class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}
                            <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </form>        
    </div>
</div>
<script>
    $('.select').select2();

</script>
<script src="{{ asset('js/eCommerce/rating.js') }}"></script>