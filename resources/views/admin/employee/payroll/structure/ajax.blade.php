<div class="p-4 row">
    <hr>
        @php
            $template_details_id = array();
            $amount = array();
        @endphp
        @foreach ($details as $item)
            @if ($item->category != 'computation' && $item->category != 'not_applicable' && $item->category != 'user_defined')
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="{{$item->id}}">
                                @if ($item->payhead->type == 'Earning')
                                    <span class="text-success">
                                        <strong>{{$item->payhead->name}}</strong>
                                        <strong><i>[{{$item->payhead->alias}}]</i></strong>
                                    </span>
                                @else 
                                    <span class="text-danger">
                                        <strong>{{$item->payhead->name}}</strong>
                                        <strong><i>[{{$item->payhead->alias}}]</i></strong>
                                    </span>
                                @endif
                                <br>
                                @if ($item->category == 'user_defined')
                                    User Defind
                                @elseif($item->category == 'not_applicable')
                                    Not Application
                                @elseif($item->category == 'attendance')
                                    On Attendance 
                                @elseif($item->category == 'flat_rate')
                                    Flat Ratio
                                @elseif($item->category == 'computation')
                                    Computaion 
                                @else
                                    On Production
                                @endif
                                (Per Month)
                            </label>         
                        </div>
                        
                        <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'}} </span>
                            </div> 
                            <input type="hidden" name="template_details_id[]" value="{{$item->id}}">
                            <input type="number" class="form-control" name="amount[]" placeholder="Enter Amount" required>       
                        </div>
                    </div>
                </div>
            @else 
                <div class="col-md-8">
                    <input type="hidden" name="template_details_id[]" value="{{$item->id}}">
                    <input type="hidden" class="form-control" name="amount[]" placeholder="Enter Amount" required>       
                </div>
            @endif
        @endforeach
    <hr>
</div>