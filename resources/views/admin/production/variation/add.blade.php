{{-- This page is for Add one more catagory dynamically --}}
<div id="hello" class="row_{{$row}} mt-2">
    <div class="row">
        <div class="col-md-5 form-group">
            {{-- <label for="value_{{$row}}">Variation Value</label> --}}
            <input type="text" required name="value[]" id="value_{{$row}}" class="form-control" placeholder="Enter Variation Value">
        </div>

        <div class="col-md-5 form-group">
            {{-- <label for="value">{{_lang('Category')}}</label> --}}
            <select required name="category_id[]" id="category_id_{{$row}}" class="form-control s_select" data-placeholder="Select Category For Size">
                <option value="">Select Category For Size</option>
                <option value="all">All Category</option>
                @php
                    $query = App\models\Production\Category::where('parent_id', 0)->where('status', 1)->get();
                @endphp
                @foreach ($query as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-1 align-right form-group">
            <button class="btn btn-danger closeAddMore text-center" data-id="row_{{$row}}"  type="button"><i class="fa fa-trash fa-3x"></i></button>
        </div>
        {{-- Delete Row Button --}}
    </div>
</div>
