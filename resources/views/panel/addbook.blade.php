@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
    <div class="content show">
        <img src="{{ asset('add-book.png') }}" alt="">
        <div class="content-info">
            <div class="d-flex justify-content-between">
                <h1 class="content-title">
                    Add Book
                </h1>
                <a href="{{ route('all-books') }}" class="btn-link">All Book</a>
            </div>
            <div class="module">
                <div class="module-body">
                    <form class="form-horizontal row-fluid" id="addBookFormId">
                        <!-- Hidden input field for bookId -->
                        <input type="hidden" id="bookId" name="bookId" value="{{ isset($book) ? $book->id : '' }}">

                        <div class="control-group">
                            <label class="control-label">Title Of Book</label>
                            <div class="controls">
                                <input type="text" id="title" name="title"
                                    value="{{ isset($book) ? $book->title : '' }}"
                                    placeholder="Enter the title of the book here..." class="span8">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="auth_user" value="{{ auth()->user()->id }}">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Author Name</label>
                            <div class="controls">
                                <input type="text" id="author" name="author"
                                    value="{{ isset($book) ? $book->author : '' }}"
                                    placeholder="Enter the name of the author for the book here..." class="span8">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="basicinput">Description of Book</label>
                            <div class="controls">
                                <textarea class="span8" id="description" name="description" rows="5"
                                    placeholder="Enter a few lines about the book here">{{ isset($book) ? $book->description : '' }}</textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="basicinput">Category</label>
                            <div class="controls">
                                <select tabindex="1" id="category" name="category_id"
                                    data-placeholder="Select category.." class="span8">
                                    @foreach ($categories_list as $category)
                                        <option value="{{ $category->id }}"
                                            {{ isset($book) && $book->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Number of Issues</label>
                            <div class="controls">
                                <input type="number" min="0" id="number" name="number"
                                    value="{{ isset($book) ? $book->number : '' }}" class="span8">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">$ Overdue Price</label>
                            <div class="controls">
                                <input type="number" min="0"
                                    value="{{ isset($book) ? $book->overdue_price : '0' }}" id="overdue_price"
                                    name="overdue_price" class="span8">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">$ Lost Price</label>
                            <div class="controls">
                                <input type="number" min="0" value="{{ isset($book) ? $book->lost_price : '0' }}"
                                    id="lost_price" name="lost_price" class="span8">
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <button type="button" class="btn btn-inverse btn-success" id="addbooks">Add Books</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@stop

@section('custom_bottom_script')

    <script type="text/javascript" src="{{ asset('static/custom/js/script.addbook_1.js') }}"></script>

@stop
