@extends('layout.index')

@section('content')
    @include('panel.book-tabs')
@endsection

@section('custom_bottom_script')
    <script type="text/javascript">
        var branches_list = $('#branches_list').val(),
            categories_list = $('#student_categories_list').val(),
            _token = $('#_token').val();
    </script>
    <script type="text/javascript" src="{{ asset('static/custom/js/script.logs_1.js') }}"></script>
    <script type="text/template" id="all_logs_display">
            @include('underscore.all_logs_display')
        </script>
    <script type="text/template" id="all_return_logs_display" >
            @include('underscore.all_logs_display')
        </script>
    <script type="text/template" id="all_overdue_logs_display" >
            @include('underscore.all_logs_display')
        </script>
    <script type="text/template" id="all_lost_logs_display" >
            @include('underscore.all_logs_display')
        </script>
    <script>
        const tabButtons = document.querySelectorAll('.tab-btn')

        tabButtons.forEach((tab) => {
            tab.addEventListener('click', () => tabClicked(tab))
        })

        function tabClicked(tab) {

            tabButtons.forEach(tab => {
                tab.classList.remove('active')
            })
            tab.classList.add('active')

            const contents = document.querySelectorAll('.content')

            contents.forEach((content) => {
                content.classList.remove('show')
            })

            const contentId = tab.getAttribute('content-id')
            const contentSelected = document.getElementById(contentId)

            contentSelected.classList.add('show')
            //console.log(contentId)
        }
    </script>
@endsection
