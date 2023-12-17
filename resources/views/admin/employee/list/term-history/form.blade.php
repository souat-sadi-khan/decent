    <div class="row">
        <!---->
        <div class="col-12 col-sm-6">
            <div class="form-group"><label for="">{{_lang('Joining Date')}}:</label>
                <p>{{ $model->date_of_joining}}</p>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form-group"><label for="">{{_lang('Joining Remarks')}}:</label>
                <p>{{($model->employee_designation AND $model->employee_designation->remarks)?$model->employee_designation->remarks:''}}</p>
            </div>
        </div>
    </div>

    <hr>
    <br>
    <div class="row">

        <div class="form-group col-md-12">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="check" class="custom-control-input status"> <span
                    class="custom-control-label text-danger">Is Leaving?</span>
            </label>
        </div>


        {{-- Leaving Date --}}
        <div class="col-md-6 form-group leave" style="display:none">
            <label for="name">{{_lang('Leaving Date')}} <span class="text-danger">*</span>
            </label>
            <input type="text" autocomplete="off" readonly="" name="date_of_leaving" id="date_of_leaving"
                class="form-control date">
        </div>



        {{-- Remarks --}}
        <div class="col-md-6 form-group leave" style="display:none">
            <label for="leaving_remarks">{{_lang('Leaving Remarks')}} <span class="text-danger"> </span>
            </label>
            <input type="text" name="leaving_remarks" id="leaving_remarks" class="form-control">
        </div>

        {{-- Upload Document --}}
        <div class="col-md-12 form-group">
            <label for="name">{{_lang('Upload Document')}} <span class="text-danger"> </span>
            </label>
            <input type="file" name="document" id="document" class="form-control">

        </div>




        <div class="form-group col-md-12" align="right">
            {{-- <input type="hidden" name="type[]" value=" "> --}}
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Save')}}<i
                    class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}
                <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
        </div>
    </div>

    <script>
        _formValidation();

        $(document).on('click', '.status', function () {

            if (this.checked == true) {
                $('.leave').fadeIn();
                $('#date_of_leaving').addAttr('required');
                $('#leaving_remarks').addAttr('required');
            } else {
                $('.leave').fadeOut();
                $('#date_of_leaving').removeAttr('required');
                $('#leaving_remarks').removeAttr('required');
            }
        });

    </script>
