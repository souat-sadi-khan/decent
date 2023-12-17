<div class="card">

    <div class="card-header">
        <h6>{{_lang('Cutomer Name - ')}} <span class="badge badge-primary">{{$model->name}}</span></h6>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <td>{{_lang('Name')}}</td>
                <td>{{$model->name}}</td>
            </tr>
            <tr>
                <td>{{_lang('email')}}</td>
                <td>{{$model->email}}</td>
            </tr>
            <tr>
                <td>{{_lang('subject')}}</td>
                <td>{{$model->subject}}</td>
            </tr>
            <tr>
                <td>{{_lang('Message')}}</td>
                <td>{{$model->descsription}}</td>
            </tr>
        </table>
    </div>
</div>