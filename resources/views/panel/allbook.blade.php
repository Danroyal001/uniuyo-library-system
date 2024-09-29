@extends('layout.index')
@section('custom_top_script')
@stop

@section('content')
    <div class="content show">
        <img src="{{ asset('books.png') }}" alt="">
        <div class="content-info">
            <div class="d-flex justify-content-between p-0">
                <h1 class="content-title">
                    All Books
                </h1>
                <a href="{{ route('add-books') }}" class="btn-link">Add Book</a>
            </div>
            <div class="module">
                <div class="module-body">
                    <div class="controls mb-2">
                        <select class="" id="category_fill">
                            <option value="">Select to filter</option>
                            @foreach ($categories_list as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Available</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="all-books">
                            <tr class="text-center">
                                <td colspan="99"> <i class="icon-spinner icon-spin"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="" id="categories_list" value="{{ json_encode($categories_list) }}">
        </div>
    </div>
@stop

@section('custom_bottom_script')
    <script type="text/javascript">
        var categories_list = $('#categories_list').val();
    </script>
    <script type="text/javascript" src="{{ asset('static/custom/js/script.addbook_1.js') }}"></script>
    <script type="text/template" id="allbooks_show">
    @include('underscore.allbooks_show')
    </script>
@stop
