<div class="card">
    <div class="card-header">
        <h6>{{_lang('Add Employee Document')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.employee-document.store')}}" method="post" id="content_form" enctype="multipart/form-data">
            @csrf
            @include('admin.employee.list.document-history.form')
        </form>
    </div>
</div>
<script type="text/javascript">

    $('.date').datepicker({
        format: "yyyy/mm/dd",
        autoclose: true,
        todayHighlight: true
    });
    $('.select').select2({ width: '100%' });

    $(document).ready(function () {
        $(document).on('change','#upload_token',function () {
            var filename = $(this).val();
            var extension = filename.replace(/^.*\./, '');
            if (extension == filename) {
                extension = '';
            } else {
                extension = extension.toLowerCase();
            }
            if (extension == 'ppt' || extension == 'doc' || extension == 'docx' || extension == 'pdf') {

            }else{
                $(this).val("");
                toastr.error('Allowed File File Formates: "doc","docx","pdf" and "ppt". But you Have Selecte Formate:"'+extension+'".');
            }
        });
    });
</script>