$('#content_form').on('submit', function(e) {
    e.preventDefault();
    $(".pageloader").show();
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
        success: function(data) {
            $(".pageloader").hide();
            toastr.success(data.message);
        },
        error: function(data) {
            var jsonValue = $.parseJSON(data.responseText);
            const errors = jsonValue.errors;
            if (errors) {
                var i = 0;
                $.each(errors, function(key, value) {
                    const first_item = Object.keys(errors)[i]
                    const message = errors[first_item][0]
                    $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');

                   toastr.error(value);
                    i++;
                });
            } else {
                toastr.error(jsonValue.message);
            }
            $(".pageloader").hide();
        }
    });
});