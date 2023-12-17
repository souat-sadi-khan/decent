<div class="card">
    <div class="card-header">
        <h6>{{_lang('Message Replay')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.contact-msg.store')}}" method="post" id="content_form">
            @csrf
            <div class="row">
                <input type="hidden" name="row_id" value="{{$model->id}}">
                    {{-- Production Ingredients Name --}}
                    <div class="col-md-12 form-group">
                        <label for="email">{{_lang('Customer Email')}} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="email" value="{{$model->email}}" id="email" class="form-control" placeholder="" required>
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="subject">{{_lang('Subject')}} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="subject" value="{{$model->subject}}" id="subject" class="form-control" placeholder="" required>
                    </div>
                 
                    {{-- Ingredients description --}}
                    <div class="col-md-12 form-group">
                        <label for="description">{{_lang('Message')}}</label>
                        <textarea name="description" class="form-control" id="summernote" placeholder="Enter description"></textarea>
                        
                    </div>
                    <div class="form-group col-md-12" align="right">
                        {{-- <input type="hidden" name="type[]" value=" "> --}}
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Send')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>        
    </div>
</div>
<script>
     $(document).ready(function() {
       $('#summernote').summernote({
           height: 300
       });
   });
</script>