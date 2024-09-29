function loadResults() {

    var url = "/books?category_id=" + $('#category_fill').val();
    // alert(url);
    var table = $('#all-books');

    // alert(table);
    var default_tpl = _.template($('#allbooks_show').html());

    $.ajax({
        url: url,
        success: function (data) {
            console.log(data);
            if ($.isEmptyObject(data)) {
                table.html('<tr><td colspan="99" style="text-align:center">No Books in this category</td></tr>');
            } else {
                table.html('');
                for (var book in data) {
                    table.append(default_tpl(data[book]));
                }
            }
        },
        beforeSend: function () {
            table.css({ 'opacity': 0.4 });
        },
        complete: function () {
            table.css({ 'opacity': 1.0 });
        }
    });
}

$(document).ready(function () {

    $("#category_fill").change(function () {

        var url = "/bookBycategory/" + $('#category_fill').val();
        // alert(url);
        var table = $('#all-books');

        // alert(table);
        var default_tpl = _.template($('#allbooks_show').html());

        $.ajax({
            url: url,
            success: function (data) {
                console.log(data);
                if ($.isEmptyObject(data)) {
                    table.html('<tr><td colspan="99" style="text-align:center">No Books in this category</td></tr>');
                } else {
                    table.html('');
                    for (var book in data) {
                        table.append(default_tpl(data[book]));
                    }
                }
            },
            beforeSend: function () {
                table.css({ 'opacity': 0.4 });
            },
            complete: function () {
                table.css({ 'opacity': 1.0 });
            }
        });
    });

    $(document).on("click", "#addbooks", function () {
        var form = $('#addBookFormId');
        var module_body = $(this).parents('.module-body');
        var send_flag = true;

        // Create a new FormData object
        var formData = new FormData(form[0]);

        // Proceed with AJAX if all fields are filled
        if (send_flag) {
            $.ajax({
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from automatically converting data to string
                contentType: false, // Prevent jQuery from automatically setting content type
                url: '/books',
                success: function (data) {
                    module_body.prepend(templates.alert_box({ type: 'success', message: data }));
                    clearform();
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    module_body.prepend(templates.alert_box({ type: 'danger', message: err.error.message }));
                    form.css({ 'opacity': '1.0' });
                },
                beforeSend: function () {
                    form.css({ 'opacity': '0.4' });
                },
                complete: function () {
                    form.css({ 'opacity': '1.0' });
                }
            });
        }
    });

    loadResults();

});


// Edit function
function editBook(id) {
    if (id) {
        var url = "/edit-books/" + id + "/edit";
        window.location.href = url;
    } else {
        alert('Invalid book ID');
    }
}


// Delete function
function deleteBook(id, element) {

    var module_body = $(element).parents('.module-body');

    if (id) {
        var url = "/delete-books/" + id;
        if (confirm("Are you sure you want to delete this book?")) {
            $.ajax({
                type: 'DELETE',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    module_body.prepend(templates.alert_box({ type: response.type, message: response.message }));
                    loadResults();
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    module_body.prepend(templates.alert_box({ type: 'danger', message: err.error.message }));
                },
            });
        }
    } else {
        alert('Invalid book ID');
    }
}




function clearform() {
    $('#title').val('');
    $('#author').val('');
    $('#description').val('');
    $('#number').val('');
    $('#category').val('');
}