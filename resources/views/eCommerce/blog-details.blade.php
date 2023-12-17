@extends('eCommerce.layouts.app')
@push('css')
<title>{{ $model->title}}</title>
<meta name="description" content="{{\Illuminate\Support\Str::limit($model->details,100)}}">
<meta name="keywords" content="">
<meta name="title" content="{{$model->title }}">
<meta property="og:title" content="{{ $model->title != '' ? $model->title : 'Blog Title' }}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit($model->details,100) }} ">
<meta property="og:image"
    content="{{isset($model->image)?asset('storage/blog/'.$model->image):'http://placehold.it/1920x205'}}">
<meta property="og:url" content="{{ route('post-details', $model->post_slug) }}">

<meta name="twitter:title" content="{{ $model->title != '' ? $model->title : 'Blog Title' }} ">
<meta name="twitter:description" content=" {{ \Illuminate\Support\Str::limit($model->details,100) }} .">
<meta name="twitter:image"
    content="{{isset($model->image)?asset('storage/blog/'.$model->image):'http://placehold.it/1920x205'}}">
<meta name="twitter:card" content="summary_large_image">
@endpush
@push('main')
<!-- Main of the Page -->
<main id="mt-main">
    <!-- Mt Contact Banner of the Page -->
    <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s"
        style="background-image: url({{isset($model->image)?asset('storage/blog/'.$model->image):'http://placehold.it/1920x205'}});">

        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h1>{!!$model->title!!}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- Mt Contact Banner of the Page end -->
    <!-- Mt Blog Detail of the Page -->
    <div class="mt-blog-detail fullwidth wow fadeInUp" data-wow-delay="0.4s">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 header">
                    <!-- Breadcrumbs of the Page -->
                    <nav class="breadcrumbs">
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}">Home <i class="fa fa-angle-right"></i></a></li>
                            <li><a href="{{route('blog')}}">Blog <i class="fa fa-angle-right"></i></a></li>
                            <li><a>{!!$model->title!!}</a></li>
                        </ul>
                    </nav>
                    <!-- Breadcrumbs of the Page end -->
                    {{-- <ul class="list-unstyled align-right">
                        <li>
                            Categories <a href="#"><i class="fa fa-bars"></i></a>
                        </li>
                    </ul> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!-- Blog Post of the Page -->
                    <article class="blog-post style3">
                        <div class="img-holder">
                            <a><img style="max-height: 575px;"
                                    src="{{isset($model->image)?asset('storage/blog/'.$model->image):'http://placehold.it/1200x575'}}"
                                    alt="image description"></a>
                            <time
                                class="time"><strong>{{formatDate2($model->date)}}</strong>{{formatMonth($model->date)}}</time>
                            <ul class="list-unstyled comment-nav">
                                <li>
                                    <div class="addthis_inline_share_toolbox"></div>
                                </li>
                                <!--<li><a href="#"><i class="fa fa-share-alt"></i>14</a></li>-->
                            </ul>
                        </div>
                        <div class="blog-txt">
                            <h2><a style="text-transform: uppercase">{!!$model->title!!}</a></h2>
                            <ul class="list-unstyled blog-nav">
                                <li> <a><i class="fa fa-clock-o"></i>{{formatDate1($model->date)}}</a></li>
                                <li> <a href="{{route('category-details',$model->category->category_slug)}}"><i
                                            class="fa fa-list"></i>{{$model->category?$model->category->name:''}}</a>
                                </li>
                            </ul>
                            <p>{!!$model->details!!}</p>
                        </div>
                    </article>

                    <!-- Mt Comments Section of the Page -->
                    <div class="mt-comments-section fullwidth">
                        <div class="mt-comments-heading">
                            <h2>COMMENTS</h2>
                        </div>
                        <ul class="list-unstyled">
                            @php
                                $blog_comment_query = App\models\eCommerce\BlogComment::where('blog_id', $model->id)->where('status', 1)->orderBy('id', 'desc')->get();
                            @endphp
                            @if (count($blog_comment_query))
                                @foreach ($blog_comment_query as $item)
                                    <li>
                                        <div class="img-box">
                                            <img src="{{ asset('user.png') }}" alt="image description">
                                        </div>
                                        <div class="txt">
                                            <h3>{{ $item->name }}</h3>
                                            <time class="mt-time" datetime="2016-02-03 20:00">{{ formatDate($model->created_at) }}</time>
                                            <p>{{ $item->message }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <!-- Mt Leave Comments of the Page -->
                        <div class="mt-leave-comment">
                            <h2>LEAVE A COMMENT</h2>
                            <form action="{{ route('submit-blog-comment') }}" id="content_form" class="comment-form">
                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                        <input type="text" class="form-control" placeholder="Phone" name="phone" id="phone">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="message" id="message" placeholder="Message"></textarea>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $model->id }}">
                                    <button type="submit" class="form-btn" id="submit">Submit</button>
                                    <button disabled type="button" id="submiting" style="display:none;" class="form-btn">Processing...</button>
                                </fieldset>
                            </form>
                        </div>
                        <!-- Mt Leave Comments of the Page end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- footer of the Page -->
@endpush

@push('scripts')
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e6f1c98ea2e3519"></script>
<script src="{{asset('backend/js/parsley.min.js')}}"></script>
<script>
    var _formValidation = function () {
    if ($('#content_form').length > 0) {
        $('#content_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#content_form').on('submit', function (e) {
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
            success: function (data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);
                } else {
                    toastr.success(data.message);
                    
                    $('#content_form')[0].reset();
                    if (data.goto) {
                        setTimeout(function () {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#content_form')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function () {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 1000);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        if (typeof(emran.ajax) != "undefined" && emran.ajax !== null) {
                            emran.ajax.reload(null, false);
                        }
                    }
                }

                $('#submit').show();
                $('#submiting').hide();
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
                // _componentSelect2Normal();
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};
    _formValidation();
</script>
@endpush
