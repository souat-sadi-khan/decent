@extends('layouts.app', ['title' => 'Member Setting Dahsboard', 'modal' => false])

{{-- Header Option --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-toggle="tooltip" data-placement="bottom" title="Savings and Credit Co-operative Management Software Member Setting Dashboard"><i class="fa fa-cogs mr-4"></i>{{_lang('Member Setting Dashboard')}}</h1>
            <p>{{_lang('Member Setting Dashboard for Savings and Credit Co-operative Management Software')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">{{ Breadcrumbs::render('member_setting') }}</li>
        </ul>
    </div>
@stop

@section('content')
<!-- Basic initialization -->

    <div class="row">

        <div class="col-md-12">
            <div class="card border-danger mb-3">
                <div class="card-header">{{_lang('Warning Information')}} </div>
                <div class="card-body text-danger">
                    <h5 class="card-title">{{_lang('Now you are in Member Setting Folder.')}} </h5>
                    <p class="card-text">When you click <strong>Member</strong>
                        in Setting Option, You came here. Thsi option is made for member general setting. You can see Religious, Nationality etc on the left sidebar. When you go to member add section you have to fill the member Religious, Nationality. There you can see a dropdown memu for that and here you can add this Information .
                    </p>
                    <p class="card-text text-center">
                        When you want to go back to the main folder . click on the link below and go to the main folder. <br>
                        <a href="{{route('home')}}">Click here to go back main folder</a>
                    </p>
                </div>
            </div>
        </div>
        
        
    </div>
@stop

