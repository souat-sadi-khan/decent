@extends('layouts.idcard')

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
@foreach ($employee as $item)
    <div class="row no-gutters">
            <div class="col-md-4 pb-3 mx-auto text-center mt-5 shadow-lg">
                <div class="bg-color">
                    <div class="pt-3">
                        @if(get_option('logo'))
                        <img class="w-50" src="{{asset('storage/logo/'.get_option('logo'))}}" alt="">
                        @else
                        <img class="w-50" src="https://sattit.com/frontend/img/Logo2.png"  alt="">
                        @endif
                    </div>
                    <div class="d-inline-block img-box">
                        <img class="w img-border rounded-circle" src="{{isset($item->photo)?asset('storage/employee/'.$item->photo):asset('profile.png')}}" alt="">
                    </div>
                </div>
                <div class="mt-3 mt-sm-5">
                    <p class="h3 mb-0 text-color"> {{$item->name}} </p>
                    <p class="text-uppercase mb-0"> <small class="font-weight-bold"> {{current_designation($item->id)}} </small></p>
                    <div class="hr-box">
                        <hr class="hr-1">
                    </div>
                </div>
                <div class="mx-auto mt-4">
                    <table class="table ml-4">
                        <tbody>
                            <tr>
                                <th scope="row">id#:</th>
                                <td>{{$item->prefix}}{{numer_padding($item->code, get_option('digits_employee_code'))}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email:</th>
                                <td>{{$item->email}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Phone:</th>
                                <td>{{$item->contact_number}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4 pb-3 mx-auto text-center mt-5 shadow-lg">
                <div class="bg-color">
                    <div class="py-5">
                        @if(get_option('logo'))
                        <img class="w-50" src="{{asset('storage/logo/'.get_option('logo'))}}" alt="">
                        @else
                        <img class="w-50" src="https://sattit.com/frontend/img/Logo2.png"  alt="">
                        @endif
                    </div>
                </div>
                <div class="mt-3 mt-sm-4 px-3">
                    <p class="h6 mb-0 text-color text-capitalize">{{get_option('site_title')}}. </p>
                    <div class="hr-box">
                        <hr class="hr-1">
                    </div>
                </div>
                <div class="mx-auto mt-4">
                    <table class="table ml-4">
                        <tbody>
                            <tr>
                                <th scope="row">Address:</th>
                                <td class="text-capitalize">{{get_option('address')}}, {{get_option('city')}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Phone:</th>
                                <td>{{get_option('phone')}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        <small>
                            @if (get_option('description'))
                                {{get_option('description')}}
                            @else
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio officiis, eos nam dolorum veritatis et odio adipisci veniam quam optio. Delectus dignissimos dicta impedit repudiandae, saepe molestias necessitatibus recusandae distinctio!
                            @endif
                        </small>
                    </p>
                </div>
            </div>
        </div>
@endforeach
@stop