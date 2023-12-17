<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edi Production Ingredients - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.production-ingredients-category.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                    {{-- Production Ingredients Name --}}
                    <div class="col-md-12 form-group">
                        <label for="name">{{_lang('Ingredients Name')}} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" value="{{$model->name}}" id="name" class="form-control" placeholder="Enter Ingredients category Name" required>
                    </div>
                 
                    {{-- Ingredients description --}}
                    <div class="col-md-12 form-group">
                        <label for="description">{{_lang('Description')}}</label>
                        <textarea name="description" class="form-control" id="" placeholder="Enter description">{{$model->description}}</textarea>
                        
                    </div>
                    {{-- Production Ingredients Status --}}
                    <div class="col-md-12 form-group">
                        <label for="name">{{_lang('Ingredients Status')}}</label>
                        <div class="toggle lg">
                            <label>
                                @if ($model->status == 1)
                                   <input name="status" id="status" checked type="checkbox" value="1"><span class="button-indecator"></span>
                                @else
                                   <input name="status" id="status" type="checkbox" value="1"><span class="button-indecator"></span>
                                @endif
                                
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Update')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>        
    </div>
</div>