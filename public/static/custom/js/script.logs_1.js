
var default_tpl;


function loadResults(status = 'issued', table = 'issue-logs-table') {

    var url = "/issue-log";

    var table = $('#' + table);

    if (status === 'issued') {
        default_tpl = _.template($('#all_logs_display').html());
    } else if (status === 'returned') {
        default_tpl = _.template($('#all_return_logs_display').html());
    } else if (status === 'overdue') {
        default_tpl = _.template($('#all_overdue_logs_display').html());
    } else if (status === 'lost') {
        default_tpl = _.template($('#all_lost_logs_display').html());
    }

    $.ajax({
        url: url,
        data: {
            status: status
        },
        success: function (data) {
            console.log(data);
            if ($.isEmptyObject(data)) {
                table.html('<tr><td colspan="99" style="text-align:center">No ' + status + ' Books</td></tr>');
            } else {
                table.html('');
                for (var log in data) {
                    table.append(default_tpl(data[log]));
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

function issueBook(bookID, studentID, returnDate, selectedForm) {
    var url = '/issue-log',
        data = {};

    data.bookID = bookID;
    data.studentID = studentID;
    data.returnDate = returnDate;
    var _token = $('#_token').val();
    // alert(_token);
    $.ajax({
        type: 'POST',
        data: {
            data: data,
            _token: _token
        },
        url: url,
        success: function (data) {
            selectedForm.prepend(templates.alert_box({ type: 'success', message: data }));
            ClearIssueBook();
            $('#issue_student_id').focus();
        },
        error: function (xhr, status, error) {

            console.log(xhr);

            var err = jQuery.parseJSON(xhr.responseText).error;
            selectedForm.prepend(templates.alert_box({ type: 'danger', message: err.message }));
        },
        beforeSend: function () {
            selectedForm.css({ 'opacity': '0.4' });
        },
        complete: function () {
            selectedForm.css({ 'opacity': '1.0' });
        }
    });
}

function returnBook(bookID, status, studentID, selectedForm) {
    var url = '/issue-log/' + bookID + '/edit';
    $.ajax({
        type: 'GET',

        url: url,
        data: { status: status, studentID: studentID },
        success: function (data) {
            loadResults();
        },
        error: function (xhr, status, error) {
            var err = jQuery.parseJSON(xhr.responseText).error;
            selectedForm.prepend(templates.alert_box({ type: 'danger', message: err.message }));
        },
        beforeSend: function () {
            selectedForm.css({ 'opacity': '0.4' });
        },
        complete: function () {
            selectedForm.css({ 'opacity': '1.0' });
        }
    });
}

function ClearReturn() {
    $('#return_book_id').val('') // if you want the value to be empty you will make the like this
}

function ClearIssueBook() {
    $('#issue_book_id').val('') // if you want the value to be empty you will make the like this
    $('#issue_student_id').val('') // if you want the value to be empty you will make the like this
}


function handleReturnBookClick(element) {
    var selectedForm = $(this).parents('form'),
        status = $(element).data('status'),
        studentID = $(element).data('studentid'),
        bookID = $(element).data('bookid');

    if (bookID == "") {
        selectedForm.prepend(templates.alert_box({ type: 'danger', message: "Invalid Data" }));
    } else {
        returnBook(bookID, status, studentID, selectedForm);
    }
}



$(document).ready(function () {
    $(document).on("click", "#issuebook", function () {
        var selectedForm = $(this).parents('form'),
            studentID = selectedForm.find("input[data-form-field~=student-issue-id]").val(),
            bookID = selectedForm.find("input[data-form-field~=book-issue-id]").val(),
            returnDate = selectedForm.find("input[data-form-field~=book-return-date]").val();

        if (studentID == "" || bookID == "" || returnDate == "") {
            selectedForm.prepend(templates.alert_box({ type: 'danger', message: "Invalid Data" }));
        } else {
            issueBook(bookID, studentID, returnDate, selectedForm);
        }
    });

    // $(document).on("click", "#returnbook", function () {
    //     var selectedForm = $(this).parents('form'),
    //         bookID = selectedForm.find("input[data-form-field~=book-issue-id]").val();
    //         bookID = selectedForm.find("input[data-form-field~=book-issue-id]").val();

    //     if (bookID == "") {
    //         selectedForm.prepend(templates.alert_box({ type: 'danger', message: "Invalid Data" }));
    //     } else {
    //         returnBook(bookID, selectedForm);
    //     }
    // });


    $(document).on("click", "#returnbook", handleReturnBookClick);


    loadResults();

});

