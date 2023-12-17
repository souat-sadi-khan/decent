<div class="row">
    <div class="col-md-5 mx-auto ">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-file-powerpoint-o fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Product Or Row Material') }}</h4>
                <p class="card-text font-80pc">{{ _lang('Send Store Request Using Product Or Row Material') }}</p> 
                {{-- <a href="{{ $row }}" class="btn btn-primary btn-sm">{{ _lang('Send Store Request') }}</a> --}}
                <a href="{{ $row }}" class="btn btn-primary btn-sm">{{ _lang('Purchase') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-5 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-file-word-o fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Work Order') }}</h4>
                <p class="card-text font-80pc">{{ _lang('Send Store Request Using Work Material') }}</p>
                {{-- <a href="{{$work }}" class="btn btn-primary btn-sm">{{ _lang('Send Store Request') }}</a> --}}
                <a href="{{$work }}" class="btn btn-primary btn-sm">{{ _lang('Purchase') }}</a>
            </div>
        </div>
    </div>
</div>