$(document).ready(function () {
    $('#myfrom').on('submit', function (e) {
        e.preventDefault();
        var submit_url = $('#myfrom').attr('action');
        var formData = new FormData($("#myfrom")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);
                } else {
                    toastr.success(data.message);
                    $('#submit').show();
                    $('#submiting').hide();
                    $('#myfrom')[0].reset();
                    if (data.goto) {
                        setTimeout(function () {

                            window.location.href = data.goto;
                        }, 2500);
                    }

                    if (data.window) {
                        $('#myfrom')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function () {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 2500);
                    }
                }
            }
        });
    });
});