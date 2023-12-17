@php
$payable = $model->total_payable;
$due = $model->due;
$paid = $model->paid;
@endphp
<div class="row">
    <div class="col-md-10 mx-auto">
        <table class="table">
            <tr class="table-primary">
                <td width="20%">Payable Amount</td>
                <td>{{get_option('currency_symbol')}} {{number_format($model->total_payable, 2)}} </td>
            </tr>
            <tr class="table-success">
                <td width="20%">Paid Amount</td>
                <td>{{get_option('currency_symbol')}} <span id="show_paid">{{number_format($paid, 2)}}</span></td>
            </tr>
            <tr class="table-danger">
                <td width="20%">Due Amount</td>
                <td>{{get_option('currency_symbol')}} <span id="show_due">{{number_format($due, 2)}}</span></td>
            </tr>
        </table>
        <form action="{{route('admin.production-work-order.pay_store')}}" method="post" id="content_form">
            <input type="hidden" name="work_order_id" value="{{$model->id}}">
            <input type="hidden" name="due" value="" id="due">
            @csrf
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="paid">{{ __('Pay Amount') }} <span class="text-danger">*</span></label>
                    <input type="number" name="paid" id="paid" class="form-control" required placeholder="Enter Paid Amount">
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="paid">{{ _lang('Method') }} </label>
                        <select name="method" class="form-control method">
                            <option value="cash">Cash</option>
                            <option value="check">Check</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 reference_no" style="display: none;">
                    <div class="form-group">
                        <label for="check_no">{{ _lang('Reference') }} </label>
                        <input type="text" class="form-control" name="check_no" id="check_no">
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="account_id">{{ _lang('Account') }} </label>
                    <select name="account_id" class="form-control select" id="account_id">
                        <option value="">Select Account</option>
                        @foreach ($accounts as $element)
                        <option>{{ $element->name }}({{ toWord($element->account_type) }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" id="submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Pay Amount</button>
            <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
        </form>
    </div>
</div>
<script>
    var total_int_payable = '{{$payable}}';
    var total_payable = parseInt(total_int_payable);
    var total_int_due = '{{$due}}';
    var total_due = parseInt(total_int_due);
    var total_int_paid = '{{$paid}}';
    var total_paid = parseInt(total_int_paid);
    var in_due = total_due + 1;

    $('#paid').keyup(function() {
        $('#show_paid').html('---');
        $('#show_due').html('---');
        var val = parseInt($(this).val());
        var due = total_due - val ;
        var paid = total_paid + val;
        $('#show_paid').html(paid.toFixed(2));
        $('#show_due').html(due.toFixed(2));
        $('#due').val(due);
    });

    // payment method
    $('.method').change(function() {
        var val = $(this).val();

        if(val == 'check' || val == 'other') {
            $('.reference_no').fadeIn();
        } else {
            $('.reference_no').fadeOut();
        }
    });
</script>