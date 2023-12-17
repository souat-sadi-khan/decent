<div class="row p-4">
    <div class="col-md-12">
        <form action="{{route('admin.employee-details.login_info',$id)}}" method="post" id="content_form">
                    {{-- Login Information --}}
        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="check" class="custom-control-input status"> <span class="custom-control-label">Enable Employee Login</span>
            </label>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="">{{_lang('User Role')}}</label> 
                  <select name="role" class="form-control select" id="role">
                      <option value="">Select Role</option>
                      @foreach ($roles as $role)
                          <option value="{{ $role->id }}">{{ $role->name }}</option>
                      @endforeach
                  </select>
            </div>
            {{-- Email --}}
             <div class="form-group col-md-6">
                <label for="">{{_lang('Email')}}</label> 
                <input readonly type="text" name="email" id="email" placeholder="Email" class="form-control">
            </div>

            {{-- Username --}}
            <div class="col-md-6 form-group">
                <label for="">{{_lang('Username')}}</label> 
                <input readonly type="text" name="username" id="username" placeholder="Username" class="form-control">
            </div>

            {{-- Password --}}
            <div class="col-md-6 form-group">
                <label for="">{{_lang('Password')}}</label> 
                <input readonly type="password" required name="password" id="password" placeholder="Password" class="form-control">
            </div>

            {{-- Confirm Password --}}
            <div class="col-md-6 form-group">
                <label for="">{{_lang('Confirm Password')}}</label> 
                <input readonly type="password" required name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control">
            </div>

        </div>

            <div class="form-group col-md-12" align="right">
                {{-- <input type="hidden" name="type[]" value=" "> --}}
                <button disabled type="submit" class="btn btn-primary"  id="submit">{{_lang('Save')}}<i class="icon-arrow-right14 position-right"></i></button>
                <button  type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}} <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
            </div>
        </form>
    </div>
</div>
<script>
        _formValidation();

    $(document).on('click', '.status', function() {

            if(this.checked == true) {
                $('#email').removeAttr('readonly');
                $('#email').attr('required', '1');
                $('#username').removeAttr('readonly');
                $('#username').attr('required', '1');
                $('#password').removeAttr('readonly');
                $('#password').attr('required', '1');
                $('#password_confirmation').removeAttr('readonly');
                $('#submit').removeAttr('disabled');
                $('#password_confirmation').attr('required', '1');
            } else {
                $('#email').attr('readonly', 'readonly');
                $('#username').attr('readonly', 'readonly');
                $('#password').attr('readonly', 'readonly');
                $('#password_confirmation').attr('readonly', 'readonly');
                $('#submit').attr('disabled', '1');
            }
        });
</script>