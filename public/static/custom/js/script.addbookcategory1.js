function loadResults() {
    var url = "/add-book-category";
    var table = $('#all-categories');
    var default_tpl = _.template($('#allcategories_show').html());

    $.ajax({
        url: url,
        success: function (data) {
            if ($.isEmptyObject(data)) {
                table.html('<tr><td colspan="12">No Books in this category</td></tr>');
            } else {
                table.html('');
                for (var category in data) {
                    table.append(default_tpl(data[category]));
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

    var _token = $('meta[name="csrf-token"]').attr('content');

    $(document).on("click", "#addbookcategory", function () {
        var form = $(this).parents('form');
        var module_body = $(this).parents('.module-body');
        var send_flag = true;
        var f$ = function (selector) {
            return form.find(selector);
        };

        var category = f$('input[data-form-field~=category]').val();

        if (category == "") {
            module_body.prepend(templates.alert_box({ type: 'danger', message: 'Category Field is Required' }));
            send_flag = false;
        }

        if (send_flag) {
            $.ajax({
                type: 'POST',
                data: {
                    category_id: $('#category_id').val(),
                    category: category,
                    _token: _token
                },
                url: '/bookcategory',
                success: function (data) {
                    module_body.prepend(templates.alert_box({ type: 'success', message: data }));
                    clearform();
                    loadResults();
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    module_body.prepend(templates.alert_box({ type: 'danger', message: err.error.message }));
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

    // Edit function
    $(document).on("click", ".edit-category", function () {
        var category = $(this).data('name');
        var category_id = $(this).data('id');
        $('#category_id').val(category_id);
        $('#category').val(category);
    });

    // Delete function
    $(document).on("click", ".delete-category", function () {
        var category_id = $(this).data('id');
        var module_body = $(this).parents('.module-body');
        if (confirm("Are you sure you want to delete this category?")) {
            $.ajax({
                type: 'POST',
                data: {
                    delete: true,
                    category_id: category_id,
                    _token: _token
                },
                url: '/bookcategory',
                success: function (data) {
                    // alert("Category deleted successfully.");
                    module_body.prepend(templates.alert_box({ type: 'success', message: 'Category deleted successfully' }));
                    loadResults();
                },
                error: function (xhr, status, error) {
                    alert("Error deleting category: " + error);
                }
            });
        }
    });

    $(".alert_box").hide().delay(5000).fadeOut();

    loadResults();
});

function clearform() {
    $('#category').val('');
    $('#category_id').val('')
}
