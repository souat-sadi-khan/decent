<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Blog Comment - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.blog-post.comment.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="row">
                    
                {{-- name --}}
                <div class="col-md-6 form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $model->name }}" placeholder="Enter Name" required>
                </div>

                {{-- email --}}
                <div class="col-md-6 form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ $model->email }}" placeholder="Enter Email" required>
                </div>

                {{-- phone --}}
                <div class="col-md-6 form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $model->phone }}" placeholder="Enter Phone" required>
                </div>

                {{-- status --}}
                <div class="col-md-6 form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control select" data-placeholder="Select One">
                        <option value="">Select One</option>
                        <option {{ $model->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $model->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                    </select>
                </div>

                {{-- message --}}
                <div class="col-md-12 form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" class="form-control" cols="30" rows="2">{{ $model->message }}</textarea>
                </div>


                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Update')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}<i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>        
    </div>
</div>
<script>
    $('.select').select2({width:'100%'});
</script>