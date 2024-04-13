@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
    <div class="content show">
        <img src="{{ asset('category.png') }}" alt="">
        <div class="content-info">
            <h1 class="content-title">
                Books Category
            </h1>
            <div class="module">
                <div class="module-body">
                    <form class="form-horizontal row-fluid">
                        <div class="control-group">
                            <label class="control-label">Category</label>
                            <div class="controls">
                                <input type="text" id="category" data-form-field="category"
                                    placeholder="Enter the category of the book here..." class="span8">
                                <input type="hidden" data-form-field="token" value="{{ csrf_token() }}">
                                <input type="hidden" name="category_id" id="category_id">
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <button type="button" class="btn btn-inverse btn-success" id="addbookcategory">Add
                                    Books</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="module col-md-10 mx-auto mt-5">
                <div class="module-body">
                    <table class="table table-striped table-bordered table-condensed ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="all-categories">
                            <tr class="text-center">
                                <td colspan="12"> <i class="icon-spinner icon-spin"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_bottom_script')
    <script type="text/javascript" src="{{ asset('static/custom/js/script.addbookcategory1.js') }}"></script>

    <script type="text/template" id="allcategories_show">
        @include('underscore.all_categories')
    </script>
@stop
