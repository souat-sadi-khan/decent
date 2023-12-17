<h3>{{ _lang('Payment History') }}</h3>
<table class="table table-bordered">
  <thead class="bg-green text-light">
    <tr>
      <th>{{ _lang('Date') }}</th>
      <th>{{ _lang('Method') }}</th>
      @can('view_sale.sale_paid')
      <th>{{ _lang('Amount') }}</th>
      @endcan
      <th>{{ _lang('Note') }}</th>
      <th>{{ _lang('Action') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($model->payment as $pay)
    <tr>
      <td>{{ $pay->payment_date }}</td>
      <td>{{ $pay->method }}</td>
      @can('view_sale.sale_paid')
      <td>{{ $pay->amount }}</td>
      @endcan
      <td>{{ $pay->note }}</td>
      <td>
        <a onclick="myFunction('{{ route('admin.sale.pos.printpayment',$pay->id)}}')" class="btn btn-info btn-sm text-light"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>