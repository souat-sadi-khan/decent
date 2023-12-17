<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edi Raw Materials - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.production-raw-materials.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                {{-- Production Unit Name  --}}
                <div class="col-md-6">
                    <label for="unit_id">{{_lang('Production Unit Name')}} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select data-parsley-errors-container="#parsley_unit_id_error" name="unit_id" id="unit_id" data-placeholder="Select One"
                            class="form-control select unit_append" required>
                            @foreach ($models as $item)
                            <option {{$model->unit_id == $item->id?'selected':'' }} value="{{$item->id}}">
                                {{$item->unit}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <span class="btn-modal btn btn-info" id="btn-modal"
                                data-url="{{ route('admin.remort_unit_modal') }}" data-container=".unit_modal">+</span>
                        </div>
                        <span id="parsley_unit_id_error"></span>
                    </div>
                </div>

                {{-- Production Raw Metrials name --}}
                <div class="col-md-6 form-group">
                    <label for="name">{{_lang('Raw Metrials Name')}} <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{$model->name}}" id="name" class="form-control"
                        placeholder="Enter Raw Metrials name" required>

                </div>

                {{-- Production Raw Metrials price --}}
                <div class="col-md-6 form-group">
                    <label for="price">{{_lang('Raw Metrials price')}} <span class="text-danger">*</span></label>
                    <input required type="text" value="{{$model->price}}" name="price" id="price" class="form-control"
                        placeholder="Enter Raw Metrials price">
                </div>
                   <div class="col-md-6 form-group">
                        <label for="client_id">{{_lang('Supplier')}} <span class="text-danger">*</span></label>
                        <select name="client_id[]" class="form-control select" multiple>
                            @foreach ($supplier as $element)
                                <option 
                                 @foreach($model->clients as $client)
                                                {{$client->id == $element->id ? 'selected' : ''}}
                                             @endforeach
                                 value="{{ $element->id }}">{{ $element->name }}</option>
                            @endforeach
                        </select>
                    </div>
                {{-- Production Raw Metrials description --}}
                <div class="col-md-12 form-group">
                    <label for="description">{{_lang('Description')}}</label>
                    <textarea name="description" class="form-control" id=""
                        placeholder="Enter Description">{{$model->description}}</textarea>
                </div>
                {{-- Production Ingredients Status --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Raw Materials Status')}}</label>
                    <div class="toggle lg">
                        <label>
                            @if ($model->status == 1)
                            <input name="status" checked id="status" type="checkbox" value="1"><span
                                class="button-indecator"></span>
                            @else
                            <input name="status" id="status" type="checkbox" value="1"><span
                                class="button-indecator"></span>
                            @endif
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-12" align="right">
                    {{-- <input type="hidden" name="type[]" value=" "> --}}
                    <button type="submit" class="btn btn-primary" id="submit">{{_lang('Update')}}<i
                            class="icon-arrow-right14 position-right"></i></button>
                    <button type="button" class="btn btn-info" id="submiting"
                        style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2({
        width: '90%'
    });

</script>
