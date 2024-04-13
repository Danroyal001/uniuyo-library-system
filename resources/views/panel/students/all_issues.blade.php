@extends('layout.index')
@section('custom_top_script')
@stop

@section('content')
    <div class="content show">
        <img src="{{ asset('student.png') }}" alt="">
        <div class="content-info">
            <div class="d-flex justify-content-between p-0">
                <h1 class="content-title">
                    {{ $student->fullname() }}'s Issued Books
                </h1>
                <a href="{{ url()->previous() }}" class="btn-link">Return</a>
            </div>
            <div class="module">
                <div class="module-body">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Issued Date</th>
                                <th>Return Date</th>
                            </tr>
                        </thead>
                        <tbody id="all-books">
                            @foreach ($issuedBooks as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td title="Description: {{ $item->book?->description }}">
                                        @if (!empty($item->stock_number))
                                            {{ $item->book?->title . ' (' . $item->stock_number . ')' }}
                                        @else
                                            {{ $item->book?->title }}
                                        @endif
                                    </td>
                                    <td>{{ $item->book?->author }}</td>
                                    <td>{{ $item->book?->category->category }}</td>
                                    <td><a class="btn btn-success">{{ $item->issued_at }}</a></td>
                                    <td><a class="btn btn-danger">{{ $item->return_date }}</a></td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
