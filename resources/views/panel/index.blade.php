@extends('layout.index')

@section('content')
    <div class="content-bg">
        <div class="row1 row-fluid1 d-flex justify-content-between">
            <div class="card col-md-6">
                <div class="card-header">Most Issued Books</div>
                <div class="card-body">
                    <!-- Most borrowed books chart -->
                    <canvas id="mostBorrowedBooksChart" width="100" height="100"></canvas>
                </div>
            </div>&nbsp;&nbsp;
            <div class="card col-md-6">
                <div class="card-header">Stock alerts</div>
                <div class="card-body">
                    <!-- Stock alerts chart -->
                    <canvas id="stockAlertsChart" width="100" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="btn-controls mt-2">

            <div class="row1 btn-box-row row-fluid1 d-flex justify-content-between gap-1">
                <button class="btn-box big span4 col-md-4 homepage-form-box" id="findbookbox">
                    <i class="icon-list"></i>
                    <b>Find Book</b>
                </button>

                <button class="btn-box big span4 col-md-4 homepage-form-box" id="findissuebox">
                    <i class="icon-book"></i>
                    <b>Find Issue Book </b>
                </button>

                <button class="btn-box big span4 col-md-4 homepage-form-box" id="findstudentbox">
                    <i class="icon-user"></i>
                    <b>Find Student</b>
                </button>
            </div>

            <div class="content">
                <div class="module" style="display: none;">
                    <div class="module-body">
                        <form class="form-horizontal row-fluid" id="findbookform">
                            <div class="control-group">
                                <label class="control-label">Name or author<br>of the book</label>
                                <div class="controls">
                                    <input type="text" class="span9" id="find_author_or_book">
                                    <a class="btn homepage-form-submit " style="background-color:  #9400D3; color:#fff"><i
                                            class="icon-search"></i> Search</a>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="" style="height: 150px; overflow:auto">
                            <table class="table table-striped table-bordered table-condensed" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Book ID</th>
                                        <th>Book Title</th>
                                        <th>Author</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="book-results"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="module" style="display: none;">
                    <div class="module-body">
                        <form class="form-horizontal row-fluid" id="findissueform">
                            <div class="control-group">
                                <label class="control-label">Enter Book ID</label>
                                <div class="controls">
                                    <input type="number" placeholder="" class="span9">
                                    <a class="btn homepage-form-submit" style="background-color:  #9400D3; color:#fff"><i
                                            class="icon-search"></i> Search</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="module-body" id="module-body-results"></div>
                </div>

                <div class="module" style="display: none;">
                    <div class="module-body">
                        <form class="form-horizontal row-fluid" id="findstudentform">
                            <div class="control-group">
                                <label class="control-label">Enter Student ID</label>
                                <div class="controls">
                                    <input type="text" placeholder="" class="span9">
                                    <a class="btn homepage-form-submit" style="background-color:  #9400D3; color:#fff"><i
                                            class="icon-search"></i> Search</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="module-body" id="module-body-results"></div>
                </div>
            </div>
        </div>
        <input type="hidden" name="" id="branches_list" value="{{ json_encode($branch_list) }}">
        <input type="hidden" name="" id="student_categories_list"
            value="{{ json_encode($student_categories_list) }}">
        <input type="hidden" name="" id="categories_list" value="{{ json_encode($categories_list) }}">
        <input type="hidden" id="_token" data-form-field="token" value="{{ csrf_token() }}">

    </div>
@stop

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('custom_bottom_script')

    <script type="text/javascript">
        var branches_list = $('#branches_list').val(),
            student_categories_list = $('#student_categories_list').val(),
            categories_list = $('#categories_list').val(),
            _token = $('#_token').val();
    </script>

    <script type="text/javascript" src="{{ asset('static/custom/js/script.mainpage1.js') }}"></script>

    <script type="text/template" id="search_book">
    @include('underscore.search_book')
</script>
    <script type="text/template" id="search_issue">
    @include('underscore.search_issue')
</script>
    <script type="text/template" id="search_student">
    @include('underscore.search_student')
</script>
    <script type="text/template" id="approvalstudents_show">
    @include('underscore.approvalstudents_show')
</script>


    <script>
        // Make AJAX request to fetch most borrowed books data
        $.ajax({
            url: '/fetch-most-borrowed-books', // Replace with your Laravel route
            type: 'GET',
            success: function(response) {
                // Aggregate data to show only one label per month
                let aggregatedData = {};
                response.forEach(item => {
                    const {
                        month,
                        title,
                        borrow_count
                    } = item;
                    if (!aggregatedData[month]) {
                        aggregatedData[month] = [];
                    }
                    aggregatedData[month].push({
                        title,
                        borrow_count
                    });
                });

                // Prepare labels and datasets for the chart
                let labels = Object.keys(aggregatedData); // Define labels here
                let datasets = Object.values(aggregatedData).map(books => {
                    return {
                        label: 'Borrow Count',
                        data: books.map(book => book.borrow_count),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        bookTitles: books.map(book => book.title) // Store book titles for each dataset
                    };
                });

                // Create the chart using the aggregated data
                var mostBorrowedBooksChartCanvas = document.getElementById('mostBorrowedBooksChart').getContext(
                    '2d');
                var mostBorrowedBooksChart = new Chart(mostBorrowedBooksChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                            xAxes: [{
                                stacked: true
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var dataset = data.datasets[tooltipItem.datasetIndex];
                                    var bookTitles = dataset.bookTitles[tooltipItem.index];
                                    var label = dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += tooltipItem.yLabel + ' Borrowed';
                                    if (bookTitles) {
                                        label += ' - ' + bookTitles;
                                    }
                                    return label;
                                }
                            }
                        }

                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });


        // // Create the chart using the aggregated data
        // var mostBorrowedBooksChartCanvas = document.getElementById('mostBorrowedBooksChart').getContext('2d');
        // var mostBorrowedBooksChart = new Chart(mostBorrowedBooksChartCanvas, {
        //     type: 'bar',
        //     data: {
        //         labels: labels,
        //         datasets: datasets
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         scales: {
        //             yAxes: [{
        //                 stacked: true,
        //                 ticks: {
        //                     beginAtZero: true
        //                 }
        //             }],
        //             xAxes: [{
        //                 stacked: true
        //             }]
        //         }
        //     }
        // });



        // Stock alerts (books with low stock) chart
        var stockAlertsChartCanvas = document.getElementById('stockAlertsChart').getContext('2d');
        var stockAlertsChart = new Chart(stockAlertsChartCanvas, {
            type: 'pie',
            data: {
                labels: {!! json_encode($stockAlerts->pluck('title')) !!},
                datasets: [{
                    label: 'Stock',
                    data: {!! json_encode($stockAlerts->pluck('stock_alert')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

@stop
