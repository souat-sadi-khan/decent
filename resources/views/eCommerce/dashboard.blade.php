@php
    $client_id = auth('client')->user()->clients_id;
    if($client_id) {
        $user = App\models\Client::where('id', $client_id)->firstOrFail();
    }
@endphp
@extends('eCommerce.layouts.app')     
@push('css')

<style>
    * {box-sizing: border-box}
        body {font-family: "Lato", sans-serif;}
    
    /* Style the tab */
    .tab {
        float: left;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        width: 30%;
        height: 450px;
    }
    
    /* Style the buttons inside the tab */
    .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
    }
    
    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }
    
    /* Create an active/current "tab button" class */
    .tab button.active {
        background-color: #ccc;
    }
    
    /* Style the tab content */
    .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid #ccc;
        width: 70%;
        border-left: none;
        min-height: 450px;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 50%;
        margin: auto;
        margin-top: 44px;
        background: #CFFFE5;
    }

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

#password_change_error {
    border: 1px solid red;
    margin-top: 10px;
    padding: 10px;
    background: #F8D7DA;
}

#personal_info_error {
    border: 1px solid red;
    margin-top: 10px;
    padding: 10px;
    background: #F8D7DA;
}

</style>

@endpush
@push('main')
<main id="mt-main">
    <section class="mt-contact-banner mt-banner-22 wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{isset($banner)?asset('storage/page/'.$banner->image):'http://placehold.it/1920x325'}});">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="text-center">My Account</h1>
                    <!-- Breadcrumbs of the Page -->
                    <nav class="breadcrumbs">
                        <ul class="list-unstyled">
                            <li><a href="{{url('/')}}">Home <i class="fa fa-angle-right"></i></a></li>
                            <li>My Account</li>
                        </ul>
                    </nav>
                    <!-- Breadcrumbs of the Page end -->
                </div>
            </div>
        </div>
    </section>

    <div class="paddingbootom-md hidden-xs"></div>
    
    <!-- Mt Product Table of the Page -->
    <div class="mt-product-table wow fadeInUp" data-wow-delay="0.4s">

        <div class="container">
            
            <div class="tab">
                <button id="defaultOpen" class="tablinks" onclick="openCity(event, 'my_orders')">My Orders</button>
                <button class="tablinks" onclick="openCity(event, 'personal_info')">Personal Information</button>
                <button class="tablinks" onclick="openCity(event, 'address_book')">Address Book</button>
                <button class="tablinks" onclick="openCity(event, 'password_manager')">Password Manager</button>
                <button class="tablinks" onclick="openCity(event, 'my_cancel_orders')">My Cancel Order</button>
                <a class='h4' href="{{route('shopping-cart-show')}}"><button class="tablinks" >Cart </button></a>
                
            </div>

            <div id="personal_info" class="tabcontent">
                <h3>Personal Information</h3>
                <p>Change your personal information from here. <span class="text-danger">If You want to change username or email, then you have to give unique username or email.</span>
                <br>
                <span class="text-danger">*</span> Containing Field Can not be Empty.
                </p>
                <div class="col-md-12 mt-5">

                    <div id="personal_info_error" style="display:none;" class="alert alert-danger"> <span class="text-danger">*</span> Field's are required</div>

                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <div class="row" style="margin-top:25px;">
                        {{-- Name --}}
                        <div class="col-md-6 form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input value="{{$user->name}}" type="text" name="name" id="name" class="form-control" placeholder="Enter Your First Name Here" required >
                        </div>

                        {{-- Last Name --}}
                        <div class="col-md-6 form-group">
                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                            <input value="{{$user->last_name}}" type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Your Last Name Here" required>
                        </div>

                        {{-- Mobile --}}
                        <div class="col-md-6 form-group">
                            <label for="mobile">Mobile <span class="text-danger">*</span></label>
                            <input value="{{$user->mobile}}" type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Your Phone Number" required>
                        </div>

                        {{-- Alternate Number --}}
                        <div class="col-md-6 form-group">
                            <label for="alternate_number">Alternate Number</label>
                            <input value="{{$user->alternate_number}}" type="text" name="alternate_number" id="alternate_number" class="form-control" placeholder="Enter Your Alternative Phone Number">
                        </div>

                        {{-- Username --}}
                        <div class="col-md-6 form-group">
                            <label for="user_name">Username <span class="text-danger">*</span></label>
                            <input value="{{$user->user_name}}" type="text" name="user_name" id="user_name" class="form-control username" placeholder="Enter Your Username Here" required>
                            <span id="usernameError" class="text-danger"></span>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input value="{{$user->email}}" type="text" name="email" id="email" class="form-control email" placeholder="Enter Your Email Address Here" required>
                            <span id="emailError" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button data-url="{{route('member.change_personal_info')}}" class="btn btn-primary btn-lg " type="button" id="personal_info_save">Save</button> 
                        <button type="button" class="btn btn-primary btn-lg" disabled  id="personal_info_saving" style="display: none;">{{_lang('Saving')}} <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></button>
                    </div>
                </div>
            </div>

            <div id="address_book" class="tabcontent">
                <h3>My Address Book</h3>
                <p class="mb-5">Here you can change your shipping address information. <br>
                    <span class="text-danger">*</span> fields are required.
                </p> 

                <div class="col-md-12 mt-5">
                    <form action="{{route('member.change_address_book')}}" method="POST" id="content_form">
                        @csrf 
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">
                            {{-- Address --}}
                            <div class="col-md-6 form-group">
                                <label for="address">Address</label>
                                <input value="{{$user->address}}" type="text" name="address" id="address" class="form-control" placeholder="Enter Your Address Here" required>
                            </div>
    
                            {{-- Postcode --}}
                            <div class="col-md-6 form-group">
                                <label for="post_code">Postcode</label>
                                <input value="{{$user->post_code}}" type="text" name="post_code" id="post_code" class="form-control" placeholder="Enter Your Postcode Here" required>
                            </div>
    
                            {{-- City --}}
                            <div class="col-md-6 form-group">
                                <label for="city">City</label>
                                <input value="{{$user->city}}" type="text" name="city" id="city" class="form-control" placeholder="Enter Your City Here" required>
                            </div>
    
                            {{-- State --}}
                            <div class="col-md-6 form-group">
                                <label for="state">State/ County</label>
                                <input value="{{$user->state}}" type="text" name="state" id="state" class="form-control" placeholder="Enter Your State/County Here" required>
                            </div>
    
                            {{-- Country --}}
                            <div class="col-md-6 form-group">
                                <label for="country">Country</label>
                                <input value="{{$user->country}}" type="text" name="country" id="country" class="form-control" placeholder="Enter Your Country Here" required>
                            </div>
    
                            {{-- Landmark --}}
                            <div class="col-md-6 form-group">
                                <label for="landmark">Landmark</label>
                                <input value="{{$user->landmark}}" type="text" name="landmark" id="landmark" class="form-control" placeholder="Enter Your Landmark Here">
                            </div>
                        </div>
    
                        <div class="text-right mt-2">
                            <button class="btn btn-primary btn-lg " type="submit" id="submit">Save</button> 
                            <button type="button" class="btn btn-primary btn-lg" disabled  id="submiting" style="display: none;">{{_lang('Saving')}} <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="password_manager" class="tabcontent">
                <h3>Password Manager</h3>
                <p>You can change your password from here.</p>

                <div id="password_change_error" style="display:none;" class="alert alert-danger">All Field's are required</div>

                <div class="row" style="margin-top:25px;">
                    {{-- Email or Username --}}
                    <div class="col-md-12 form-group">
                        <label for="email_or_username">Email Address Or User Name</label>
                        <input type="text" name="email_or_username" id="email_or_username" class="form-control" required placeholder="Enter Your Email or Username Here">
                    </div>

                    {{-- New Password --}}
                    <div class="col-md-6 form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required placeholder="Enter Your New Password Here">
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6 form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Enter Your New Password Again Here">
                    </div>
                </div>

                <div class="text-right">
                    <button data-url="{{route('member.chage_password')}}" type="button" name="change_password" id="change_password" class="brn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary btn-lg" disabled  id="change_password_saving" style="display: none;">{{_lang('Saving')}} <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i></button>
                </div>

            </div>

            <div id="my_orders" class="tabcontent">
                <h3>My Orders</h3>
                <p>You can view all of your orders from here.</p>
                <div class="mt-3 col-md-12 table-responsive" style="margin-top:25px;">
                    <table class="table table-hover table-bordered content_managment_table">
                        <thead>
                            <tr>
                                <th>{{_lang('ID')}}</th>
                                <th>{{_lang('Payment Type')}}</th>
                                <th>{{_lang('Track Code')}}</th>
                                <th>{{_lang('Subtotal')}}</th>
                                <th>{{_lang('Shipping Name')}}</th>
                                <th>{{_lang('Phone')}}</th>
                                <th>{{_lang('Total')}}</th>
                                <th>{{_lang('Date')}}</th>
                                <th>{{_lang('Status')}}</th>
                                <th>{{_lang('Print')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $models = App\models\Production\Transaction::where('client_id', $user->id)->where('ecommerce_status', '!=', 'cancel')->orderBy('id', 'desc')->get();
                            @endphp
                            @if (count($models) > 0)
                                @foreach ($models as $model)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$model->payment_status}}</td>
                                        <td>{{$model->reference_no}}</td>
                                        <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->sub_total}}</td>
                                        <td>{{get_client_name($model->client_id)}}</td>
                                        <td>{{get_client_phone($model->client_id)}}</td>
                                        <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->net_total}}</td>
                                        <td>{{formatDate($model->created_at)}}</td>
                                        <td>
                                            @if ($model->ecommerce_status == 'pending')
                                                {{_lang('Pending')}}
                                            @elseif( $model->ecommerce_status == 'confirm')
                                                {{_lang('Confirm')}}
                                            @elseif( $model->ecommerce_status == 'progressing')
                                                {{_lang('In Progressing')}}
                                            @elseif( $model->ecommerce_status == 'shipment')
                                                {{_lang('In Shipment')}}
                                            @elseif( $model->ecommerce_status == 'success')
                                                {{_lang('Success')}}
                                            @else 
                                                {{_lang('Cancel')}}
                                            @endif
                                        </td>
                                        <td><a href="{{ route('invoice', $model->reference_no) }}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a></td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="9" class="text-center">No Records Found !</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="my_cancel_orders" class="tabcontent">
                <h3>Cancel Order</h3>
                <p>You can see all of your cancel order from here.</p>
                <div class="mt-3 col-md-12 table-responsive" style="margin-top:25px;">
                    <table class="table table-hover table-bordered content_managment_table">
                        <thead class="thead-dark">
                            <tr>
                                <th>{{_lang('ID')}}</th>
                                <th>{{_lang('Payment Type')}}</th>
                                <th>{{_lang('Track Code')}}</th>
                                <th>{{_lang('Subtotal')}}</th>
                                <th>{{_lang('Shipping Name')}}</th>
                                <th>{{_lang('Phone')}}</th>
                                <th>{{_lang('Total')}}</th>
                                <th>{{_lang('Date')}}</th>
                                <th>{{_lang('Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $models = App\models\Production\Transaction::where('client_id', $user->id)->where('ecommerce_status', 'cancel')->orderBy('id', 'desc')->get();
                            @endphp
                            @if (count($models) > 0)
                                @foreach ($models as $model)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$model->payment_status}}</td>
                                        <td>{{$model->reference_no}}</td>
                                        <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->sub_total}}</td>
                                        <td>{{get_client_name($model->client_id)}}</td>
                                        <td>{{get_client_phone($model->client_id)}}</td>
                                        <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->net_total}}</td>
                                        <td>{{formatDate($model->created_at)}}</td>
                                        <td>
                                            @if ($model->ecommerce_status == 'pending')
                                                {{_lang('Pending')}}
                                            @elseif( $model->ecommerce_status == 'confirm')
                                                {{_lang('Confirm')}}
                                            @elseif( $model->ecommerce_status == 'progressing')
                                                {{_lang('In Progressing')}}
                                            @elseif( $model->ecommerce_status == 'shipment')
                                                {{_lang('In Shipment')}}
                                            @elseif( $model->ecommerce_status == 'success')
                                                {{_lang('Success')}}
                                            @else 
                                                {{_lang('Cancel')}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="9" class="text-center">No Records Found !</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="track_order" class="tabcontent">
                <h3>Track Order</h3>
                <p>Here you can track all of your order stattus from here</p>
                <div class="col-md-12 mt-5">
                    <div class="row">
                        {{-- Tracking Code --}}
                        <div class="col-md-12 form-group">
                            <label for="code">Tracking Code</label>
                            <input type="text" name="code" id="code" class="form-control" placeholder="Enter Your Tracking Code Here" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <button data-url="{{route('member.client_track_code')}}" type="button" name="track_code" id="track_code" class="brn btn-info btn-lg">Track</button>
                        <button type="button" class="btn btn-primary btn-lg" disabled  id="track_code_submitting" style="display: none;">{{_lang('Tracking')}} <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i></button>
                    </div>

                    <div id="track_status">
                        
                    </div>
                </div>
            </div>

        </div>

    </div>    
    <div class="paddingbootom-md hidden-xs"></div>

</main>
<!-- footer of the Page -->
@endpush

@push('scripts')
<script src="{{ asset('backend/js/parsley.min.js') }}"></script>
<script>

    // personal_info
    $('#personal_info_save').click(function() {
        var id = $('#id').val();
        var name = $('#name').val();
        var last_name = $('#last_name').val();
        var mobile = $('#mobile').val();
        var alternate_number = $('#alternate_number').val();
        var user_name = $('#user_name').val();
        var email = $('#email').val();

        if ( name != '' && last_name != '' && mobile != '' && user_name != '' && email != '') {

            $('#personal_info_error').fadeOut();
            $('#personal_info_save').hide();
            $('#personal_info_saving').show();
            var url = $(this).data('url');
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    name:name, last_name:last_name, mobile:mobile, alternate_number:alternate_number, user_name:user_name, email:email, id:id
                },
                success: function (data) {
                    if(data.status == 'success') {
                        $('#track_status').html(data.html);
                        toastr.success(data.message);
                    }
                    if(data.status == 'error') {
                        toastr.error(data.message);
                    }
                    $('#personal_info_save').show();
                    $('#personal_info_saving').hide();
                }
            });

        } else {
            $('#personal_info_error').fadeIn();
        }

    });

    // email check
    $('.email').on('blur', function() {
        var val = $(this).val();
        var val = val.trim();
        if(val != '') {
            $.ajax({
                type:'GET',
                url:'/member/check_email_is_exist_or_not',
                data:{val : val},
                success:function(data){
                    $('#emailError').html(data);
                }
            });
        }
    });

    // username check
    $('.username').on('blur', function() {
        var val = $(this).val();
        
        var val = val.trim();
        if(val != '') {
            $.ajax({
                type:'GET',
                url:'/member/check_user_name_is_exist_or_not',
                data:{val : val},
                success:function(data){
                    $('#usernameError').html(data);
                }
            });
        }
    })
    
    // password change
    $('#change_password').click(function() {
        var status = true;

        var email_or_username = $('#email_or_username').val();
        var new_password = $('#new_password').val();
        var password_confirmation = $('#password_confirmation').val();
        if(email_or_username != '' && new_password != '' && password_confirmation != '') {

            if(new_password != password_confirmation) {
                $('#password_change_error').show();
                $('#password_change_error').html('Password Does not Match Properly !');
                status = false ;
            }

            if (status == true) {
                $('#password_change_error').hide();
                $('#track_status').html('');
                $('#change_password').hide();
                $('#change_password_saving').show();
                var url = $(this).data('url');

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        email_or_username:email_or_username, new_password: new_password, password_confirmation:password_confirmation,
                    },
                    success: function (data) {
                        if (data.status == 'danger') {
                            toastr.error(data.message);

                        } else {
                            toastr.success(data.message);
                            
                            $('.form_submition')[0].reset();
                            
                            if (data.load) {
                                setTimeout(function() {

                                    window.location.href = "";
                                }, 2500);
                            }
                        }

                        $('#change_password').show();
                        $('#change_password_saving').hide();
                    }
                });
            }
            
        } else {
            $('#password_change_error').show();
        }
    });

    // order Tracking
    $('#track_code').click(function() {
        var code = $('#code').val();
        if(code != '') {
            $('#track_status').html('');
            $(this).hide();
            $('#track_code_submitting').show();
            var url = $(this).data('url');
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    code:code,
                },
                success: function (data) {
                    if(data.status == 'success') {
                        $('#track_status').html(data.html);

                    }
                    if(data.status == 'error') {
                        $('#track_status').html(data.html);
                        $("p").css("background-color");

                    }
                    $('#track_code').show();
                    $('#track_code_submitting').hide();
                }
            });
        }
    });


    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();

    var _formValidation = function() {
        if ($('#content_form').length > 0) {
            $('#content_form').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });
        }

        $('#content_form').on('submit', function(e) {
            e.preventDefault();
            $('#submit').hide();
            $('#submiting').show();
            $(".ajax_error").remove();
            var submit_url = $('#content_form').attr('action');
            //Start Ajax
            var formData = new FormData($("#content_form")[0]);
            $.ajax({
                url: submit_url,
                type: 'POST',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'danger') {
                        toastr.error(data.message);

                    } else {
                        toastr.success(data.message);
                        $('#submit').show();
                        $('#submiting').hide();
                        $('#content_form')[0].reset();
                        if (data.goto) {
                            setTimeout(function() {

                                window.location.href = data.goto;
                            }, 500);
                        }

                        if (data.window) {
                            $('#content_form')[0].reset();
                            window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                            setTimeout(function() {
                                window.location.href = '';
                            }, 1000);
                        }

                        if (data.load) {
                            setTimeout(function() {

                                window.location.href = "";
                            }, 2500);
                        }
                    }
                },
                error: function(data) {
                    var jsonValue = $.parseJSON(data.responseText);
                    const errors = jsonValue.errors;
                    if (errors) {
                        var i = 0;
                        $.each(errors, function(key, value) {
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
                    $('#submit').show();
                    $('#submiting').hide();
                }
            });
        });
    };

    _formValidation();
    
    @if(\Session::has('error'))
        toastr.warning('{{\Session::get("error")}}');
    @endif

</script>

@endpush