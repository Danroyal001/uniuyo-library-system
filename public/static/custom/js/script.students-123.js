var globalTable;
var globalStatus;
var default_tpl;


function updateSlug(slug) {
    var newSlug = slug; // Replace 'your-slug' with the desired slug
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

function loadResults(status = 'new', table = 'new-table') {
    var url = "/getStudentByAttribute/";

    var table = $('#' + table);
    globalTable = table;

    if (status === 'new') {
        default_tpl = _.template($('#approvalstudents_show').html());
    } else if (status === 'approved') {
        default_tpl = _.template($('#allstudents_show').html());
    } else if (status === 'rejected') {
        default_tpl = _.template($('#rejectstudents_show').html());
    } else if (status === 'blocked') {
        default_tpl = _.template($('#blockstudents_show').html());
    }

    updateSlug(status);

    $.ajax({
        url: url,
        data: {
            year: $('#' + status + '_year_select').val(),
            category: $('#' + status + '_category_select').val(),
            branch: $('#' + status + '_branch_select').val(),
            status: status
        },
        success: function (data) {
            if (isEmptyObject(data)) {
                table.html('<tr><td colspan="12" style="text-align:center">No Students found for these filters</td></tr>');
            } else {
                table.html('');
                for (var student in data) {
                    table.append(default_tpl(data[student]));
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

function getBranch(element) {
    var status = element.getAttribute('data-status');
    var table = status + '-table';
    loadResults(status, table);
}

function getCategory(element) {
    var status = element.getAttribute('data-status');
    var table = status + '-table';
    loadResults(status, table);
}

function getYear(element) {
    var status = element.getAttribute('data-status');
    var table = status + '-table';
    loadResults(status, table);
}

$(document).ready(function () {

    var table = getSlug() + '-table';

    loadResults(getSlug(), table);

    $(document).on("click", ".student-status", function () {
        var selectedRow = $(this).parents('tr');
        var studentID = selectedRow.data('student-id');
        var flag = $(this).data('status');
        var table = $(this).data('table');

        approveStudent(studentID, flag, $(this), table);
    });
});

function approveStudent(studentID, flag, btn, tables) {
    var module_body = btn.parents('.module-body');
    var table = $(btn.data('table'));
    var tableStatus = btn.data('table');
    // alert();

    $.ajax({
        type: 'POST',
        data: {
            _method: "PUT",
            flag: flag,
            _token: _token
        },
        url: '/student/' + studentID,
        success: function (data) {
            console.log(tableStatus.replace('-table', ''), btn.data('table'));
            module_body.prepend(templates.alert_box({ type: 'success', message: data }));
            loadResults(tableStatus.replace('-table', ''), btn.data('table'));
        },
        error: function (xhr, msg) {
            module_body.prepend(templates.alert_box({ type: 'danger', message: msg }));
        },
        beforeSend: function () {
            table.css({ 'opacity': '0.4' });
        },
        complete: function () {
            table.css({ 'opacity': '1.0' });
        }
    });
}


function showBookIssued(id) {
    if (id) {
        var url = "/student-issue-books/" + id;
        window.location.href = url;
    } else {
        alert('Invalid student ID');
    }
}


function resetFilter(status) {
    $('#' + status + '_year_select').val(0);
    $('#' + status + '_category_select').val(0);
    $('#' + status + '_branch_select').val(0);
    var table = status + '-table';
    loadResults(status, table);
}

