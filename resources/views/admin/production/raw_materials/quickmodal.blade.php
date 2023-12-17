<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-light border-grey-300">
            <h5 class="modal-title"></h5>
            <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    <h6>{{_lang('Add New Raw Materials')}}</h6>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.addremort_material')}}" method="post" class="remort_addClass">
                        @csrf
                        <div class="row">
                            {{-- Production Unit Name  --}}
                            <div class="col-md-6">
                                <label for="unit_id">{{_lang('Production Unit Name')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="unit_id" id="unit_id" data-placeholder="Select One" class="form-control material_select unit_append" required>
                                        <option value="">Select One</option>
                                        @foreach ($models as $item)
                                        <option value="{{$item->id}}">{{$item->unit}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <span class="btn-modal btn btn-info" id="btn-modal" data-url="{{ route('admin.remort_unit_modal') }}" data-container=".unit_modal">+</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Production Raw Metrials name --}}
                            <div class="col-md-6 form-group">
                                <label for="name">{{_lang('Raw Metrials Name')}} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Raw Metrials name" required>
                                
                            </div>
                            {{-- Production Raw Metrials price --}}
                            <div class="col-md-6 form-group">
                                <label for="price">{{_lang('Raw Metrials price')}}</label>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Enter Raw Metrials price">
                            </div>
                            {{-- Production Raw Metrials description --}}
                            <div class="col-md-6 form-group">
                                <label for="description">{{_lang('Description')}}</label>
                                <textarea name="description" class="form-control" id="" placeholder="Enter Description"></textarea>
                            </div>
                            {{-- Production Ingredients Status --}}
                            <div class="col-md-12 form-group">
                                <label for="name">{{_lang('Raw Materials Status')}}</label>
                                <div class="toggle lg">
                                    <label>
                                        <input name="status" id="status" type="checkbox" value="1"><span class="button-indecator"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-12" align="right">
                                {{-- <input type="hidden" name="type[]" value=" "> --}}
                                <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                                <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.material_select').select2({
width:'87%'
});
</script>