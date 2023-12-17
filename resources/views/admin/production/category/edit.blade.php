<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Production Catagory - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.production-category.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">

                {{-- Select Parent Category --}}
                <div class="form-group col-md-6">
                    <label>{{_lang('Select Parent Category')}} <span class="text-danger">*</span></label>
                    <select required data-placeholder="Select Parent Catagory" name="parent_id" id="catagory_id" class="form-control select">
                        <option value="">Select Parent Catagory</option>
                        @if ($model->parent_id==0)
                        <option value="0" selected>As A Parent</option>
                        @else
                        @php
                            $item =App\models\Production\Category::find($model->parent_id); 
                        @endphp
                        <option selected value="{{$item->id}}"> {{ $item->name }}
                            @php
                                $sub=\App\models\Production\Category::where('parent_id',$item->parent_id)->first();
                            @endphp
                            @if ($sub->catagory)
                                ({{$sub->catagory->name}})
                            @endif
                        </option>
                        @endif
                    </select>
                </div>

                {{-- Production Category Name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Category Name')}} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" value="{{$model->name}}" id="name" class="form-control"
                        placeholder="Enter Production Category Name" required>
                </div>
                {{-- Production Category Description --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Category Description')}}
                    </label>
                    <textarea name="description" class="form-control" id=""
                        placeholder="Enter Production Category Description">{{$model->description}}</textarea>
        
                </div>

                {{-- Production Category Status --}}
                    <div class="col-md-12 form-group">
                        <label for="name">{{_lang('Category Status')}}
                        </label>
                        <div class="toggle lg">
                            <label>
                                <input name="status" {{$model->status == 1? 'checked':''}} id="status" type="checkbox" value="1"><span class="button-indecator"></span>
                            </label>
                        </div>
                    </div>

                     
                @can('production_category.update')
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary" id="submit">{{_lang('Save')}}<i
                                class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
                            <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                @endcan
            </div>
        </form>        
    </div>
</div>
<script>
    $('.select').select2();
</script>
<script src="{{ asset('js/production/category.js') }}"></script>