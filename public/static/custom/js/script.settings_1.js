var default_tpl;
var table;

function updateSlug(slug) {
    var newSlug = slug;
    var baseUrl = window.location.origin;
    var newPath = window.location.pathname.split('/').slice(0, -1).join('/') + '/' + newSlug;
    var newUrl = baseUrl + newPath;
    window.history.pushState(null, '', newUrl);
}

function getSlug() {
    var pathParts = window.location.pathname.split('/');
    var slug = pathParts[pathParts.length - 1];
    return slug;
}

function loadResults(status = 'branch', table = 'branch-table') {

    var url = "/settings";

    var table = $('#' + table);
    default_tpl = _.template($('#' + status + '_show').html());
    table = table;

    updateSlug(status);

    $.ajax({
        url: url,
        data: { status: status },
        success: function (data) {

            if (isEmptyObject(data)) {
                table.html('<tr><td colspan="12">' + data + '</td></tr>');
            } else {
                table.html('');
                for (var setting in data) {
                    table.append(default_tpl(data[setting]));
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

function editData(element) {
    var status = $(element).data('status');
    if (status === 'branch') {
        $('#branch').val($(element).data('name'));
        $('#branch_id').val($(element).data('id'));
        $('#addBranch').text('Update Branch');
    } else {
        $('#student_category').val($(element).data('name'));
        $('#student_category_id').val($(element).data('id'));
        $('#max_allow').val($(element).data('max'));
        $('#addStudentCategory').text('Update Student Category');
    }

}


function handleFormSubmition(element) {
    var form = $(element).parents('form');
    var module_body = $(element).parents('.module-body');
    var formData = new FormData(form[0]); // Construct FormData object from form
    var send_flag = true;

    // alert(formData.get('branch'));

    // Check if the required form fields are empty
    if (formData.get('branch') === '') {
        module_body.prepend(templates.alert_box({ type: 'danger', message: 'Branch Field is Required' }));
        send_flag = false;
    }

    if (formData.get('student_category') === '' || formData.get('max_allowed') === '') {
        module_body.prepend(templates.alert_box({ type: 'danger', message: 'All Fields are Required' }));
        send_flag = false;
    }

    // If all required fields are filled, proceed with AJAX request
    if (send_flag) {
        $.ajax({
            type: 'POST',
            data: formData, // Send FormData object
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting content type
            url: '/setting',
            success: function (data) {
                module_body.prepend(templates.alert_box({ type: 'success', message: data }));
                var table = getSlug() + '-table';
                table = table;
                loadResults(getSlug(), table);
                if (getSlug() === 'category') {
                    clearform();
                } else {
                    clearform1();
                }
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
}


// Delete function
function handleDeleteData(id, element, status) {

    var module_body = $(element).parents('.module-body');

    if (id) {
        var url = "/delete-setting/" + id;
        if (confirm("Are you sure you want to delete this data?")) {
            $.ajax({
                type: 'DELETE',
                url: url,
                data: { status: status },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    module_body.prepend(templates.alert_box({ type: response.type, message: response }));
                    var table = getSlug() + '-table';
                    table = table;

                    loadResults(getSlug(), table);
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


$(document).ready(function () {


    $(".alert_box").hide().delay(5000).fadeOut();

    var table = getSlug() + '-table';
    table = table;

    loadResults(getSlug(), table);

});

function clearform() {
    $('#student_category').val('');
    $('#max_allow').val('');
    $('#addStudentCategory').text('Add Student Category');
}

function clearform1() {
    $('#branch').val('');
    $('#addBranch').text('Add Branch');
}