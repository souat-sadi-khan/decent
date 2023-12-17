<div class="card">
    <div class="card-header">
        <h6>{{_lang('Update Subscriber')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.subscribers.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
                <div class="row">
                    {{-- Status--}}
                    <div class="col-md-12 form-group">
                        <label for="name">{{_lang('Status')}} <span class="text-danger">*</span>
                        </label>
                        <select data-placeholder="Select Status" name="status" id="status" class="form-control select">
                        <option value="">{{_lang('Select Status')}}</option>
                        <option {{ $model->status == 1 ? 'selected' : '' }} value="1">{{_lang('Active')}}</option>
                        <option {{ $model->status == 0 ? 'selected' : '' }} value="0">{{_lang('Inactive')}}</option>
                    </select>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-12 form-group">
                       <label for="news_letter_email">Subscriber Email <span class="text-danger">*</span></label>
                       <input type="email" name="news_letter_email" id="news_letter_email" class="form-control" placeholder="Enter Subscriber Email" value="{{ $model->news_letter_email }}" required>
                    </div>


                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Save')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2();
</script>
