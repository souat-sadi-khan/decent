@extends('layouts.app', ['title' => _lang('Production Product For Ecommerce'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
    <link rel="stylesheet" href="{{asset('backend/css/tagsinput.css')}}">
@endpush
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Product for Ecommerce."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Ecommerce Product Details Add')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('product-details') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-product.details-store', $id)}}" method="post" id="content_form"
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Add New Production Product')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Short Description --}}
                <div class="col-md-6 form-group">
                    <label for="short_description">{{_lang('Short Description')}} <span class="text-danger">*</span>
                    </label>
                    <textarea  name="short_description" id="short_description" class="form-control" placeholder="Enter Short Description" required>{{ $model->short_description }}</textarea>
                </div>
                {{-- Information --}}
                <div class="col-md-6 form-group">
                    <label for="information">{{_lang('Information')}} <span class="text-danger">*</span>
                    </label>
                    <textarea  name="information" id="information" class="form-control" placeholder="Enter Information" >{{ $model->information }}</textarea>
                </div>
                {{-- Product Details --}}
                <div class="col-md-12 form-group">
                    <label for="product_description">{{_lang('Description')}}
                    </label>
                    <textarea name="product_description" class="form-control summernote" id="product_description" required
                        placeholder="Enter Product Details">{{ $model->product_description }}</textarea>
                </div>

                {{-- Select Image --}}
                <div class="col-md-12">
                   <div class="card card-box border border-primary">
                       <div class="card-title">
                           <h5>{{ _lang('Photo Upload') }}</h5>
                       </div>
                       <div class="card-body">
                           <table class="table table-bordered">
                               <thead>
                                   <tr>
                                       <th width="80%">{{ _lang('Photo') }}</th>
                                       <td width="20%"><button type="button" class="btn btn-success" id="adddoc">+</button></td>
                                   </tr>
                               </thead>
                               <tbody id="documentadd">
                                   @foreach ($model->photo_details as $element)
                                     <tr>
                                         <td>
                                            <input type="file" name="photo[]" class="form-control dropify" data-height="100" data-allowed-file-extensions="jpg jpeg png"/ data-default-file="{{ asset('storage/product/'.$element->photo) }}" value="{{$element->photo }}" > 
                                            <input type="hidden" name="old_photo[]" value="{{ $element->photo }}">
                                            <input type="hidden"name="hidden_value[]"/ value="1">
                                         </td>
                                         <td>
                                           <button type="button" name="remove"  class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button>  
                                         </td>
                                     </tr>
                                   @endforeach
                               </tbody>
                           </table>
                       </div>
                   </div>
                </div>

                {{-- Seo Title --}}
                <div class="col-md-12 form-group">
                    <label for="seo_title">{{_lang('Seo Title')}}</label>
                    <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{ $model->seo_title }}">
                </div>

                {{-- Meta Title --}}
                <div class="col-md-6 form-group">
                    <label for="title">{{_lang('Meta Title')}}</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ $model->seo_title }}" >
                </div>
                {{-- Meta Keyword --}}
                <div class="col-md-6 form-group">
                    <label for="keyword">{{_lang('Meta Keyword')}}</label>
                    <input type="text" class="form-control" data-role="tagsinput" name="keyword" id="keyword" value="{{ $model->keyword }}">
                </div>

                {{-- Meta Description --}}
                <div class="col-md-12 form-group">
                    <label for="meta_description">{{_lang('Meta Description')}}</label>
                    <textarea name="meta_description" class="form-control" id="meta_description"
                        placeholder="Enter Meta Description">{{ $model->meta_description }}</textarea>
                </div>
            </div>
            
        </div>
        <div class="form-group col-md-12" align="right">
            <button type="submit" id="submit" class="btn btn-sm btn-primary">+{{ _lang('Add Details') }}</button>
            <button type="button" class="btn btn-info btn-sm" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
    </div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('js/production/product.js') }}"></script>
<script src="{{ asset('js/production/add_product.js') }}"></script>
<script src="{{asset('backend/js/tagsinput.js')}}"></script>
<script>
@if (!isset($model->photo_details))
 adddoc();
@endif   
$("#adddoc").on('click', function(){
 adddoc()
 });
function adddoc()
{
  var html = '';
  html += '<tr>';
  html += '<td><input type="file" name="photo[]" class="form-control dropify" data-height="100" data-allowed-file-extensions="jpg jpeg png"/><input type="hidden"name="hidden_value[]" value="1"/></td>';
  html += '<td><button type="button" name="remove"  class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button></td></tr>';
  $('#documentadd').append(html);
  _componentDropFile();
}

 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 }); 
</script>
@endpush
