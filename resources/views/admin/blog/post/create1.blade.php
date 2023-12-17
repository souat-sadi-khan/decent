<div class="card">
    <div class="card-header">
        <h6>{{_lang('Add New Blog Post')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.eCommerce.blog-post.store')}}" method="post" id="content_form">
            @csrf
                <div class="row">

                     {{-- Select Catagory --}}
                <div class="col-md-6 form-group">
                    <label for="category">{{_lang('Select Category')}}
                    </label>
                    <select required data-placeholder="Select Catagory" name="category" id="category"
                        class="form-control select">
                        <option value="">{{_lang('Select Catagory')}}</option>
                        @foreach ($models as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>


                    {{-- Blog Post Title --}}
                    <div class="col-md-6 form-group">
                        <label for="title">{{_lang('Blog Post Title')}} <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Blog Post Title" required>
                    </div>


                    
                     {{-- Select Image --}}
                <div class="col-md-12 form-group">
                    <label for="photo">{{_lang('Upload Post Photo')}}</label>
                    <input type="file" name="photo" id="photo" class="dropify"  />
                </div>

                    {{-- Post Details --}}
                <div class="col-md-12 form-group">
                    <label for="details">{{_lang('Details')}}
                    </label>
                    <textarea name="details" class="form-control summernote" id="details"
                        placeholder="Enter Post Details"></textarea>
                </div>


                    
                    <div class="col-md-6 form-group">
					<label for="date">{{_lang('Date')}}</label>
					<div class="input-group mb-3">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
						</div>
						<input type="text" class="form-control take_date" name="date" id="date" value="{{ date('Y-m-d') }}">
					</div>
                </div>
                

                    {{-- Blog Post Status --}}
                    <div class="col-md-6 form-group">
                        <label for="status">{{_lang('Post Status')}}
                        </label>
                        <select data-placeholder="Post Status" name="status" id="status"
                            class="form-control select">
                            <option selected value="Active">{{_lang('Active')}}</option>
                            <option value="InActive">{{_lang('InActive')}}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12" align="right">
                        <button type="submit" class="btn btn-primary"  id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
                        <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}   <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
    </div>
</div>


<script>

    $('.select').select2();
        $(document).ready(function () {
             _componentDatePicker();
            $('.summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link']]
                ]
            });
        });

               _componentDropFile();
        var _ImageUpload = function () {
            if ($('#imageUpload').length > 0) {
                $('#imageUpload').parsley().on('field:validated', function () {
                    var ok = $('.parsley-error').length === 0;
                    $('.bs-callout-info').toggleClass('hidden', !ok);
                    $('.bs-callout-warning').toggleClass('hidden', ok);
                });
            }

            $('#imageUpload').on('submit', function (e) {
                e.preventDefault();
                $('#submit_photo').hide();
                $('#submiting_photo').show();
                $(".ajax_error").remove();
                var submit_url = $('#imageUpload').attr('action');
                //Start Ajax
                var formData = new FormData($("#imageUpload")[0]);
                $.ajax({
                    url: submit_url,
                    type: 'POST',
                    data: formData,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status == 'danger') {
                            toastr.error(data.message);

                        } else {
                            toastr.success(data.message);
                            $('#submit_photo').show();
                            $('#submiting_photo').hide();
                            $('#imageUpload')[0].reset();
                            if (data.goto) {
                                setTimeout(function () {

                                    window.location.href = data.goto;
                                }, 500);
                            }

                            if (data.window) {
                                $('#imageUpload')[0].reset();
                                window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                                setTimeout(function () {
                                    window.location.href = '';
                                }, 1000);
                            }

                            if (data.load) {
                                setTimeout(function () {

                                    window.location.href = "";
                                }, 2500);
                            }
                        }
                    },
                    error: function (data) {
                        var jsonValue = $.parseJSON(data.responseText);
                        const errors = jsonValue.errors;
                        if (errors) {
                            var i = 0;
                            $.each(errors, function (key, value) {
                                const first_item = Object.keys(errors)[i]
                                const message = errors[first_item][0];
                                if ($('#' + first_item).length > 0) {
                                    $('#' + first_item).parsley().removeError('required', {
                                        updateClass: true
                                    });
                                    $('#' + first_item).parsley().addError('required', {
                                        message: value,
                                        updateClass: true
                                    });
                                }
                                // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                                toastr.error(value);
                                i++;
                            });
                        } else {
                            toastr.warning(jsonValue.message);

                        }
                        _componentSelect2Normal();
                        $('#submit_photo').show();
                        $('#submiting_photo').hide();
                    }
                });
            });
        };

        _ImageUpload();
</script>
