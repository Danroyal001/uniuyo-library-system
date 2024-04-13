@extends('layout.index')

@section('content')
    @include('panel.dashboard.tabs')

@stop


@section('custom_bottom_script')
    <script type="text/javascript">
        var branches_list = $('#branches_list').val(),
            student_categories_list = $('#student_categories_list').val(),
            categories_list = $('#categories_list').val(),
            _token = $('#_token').val();
    </script>

    <script type="text/javascript" src="{{ asset('static/custom/js/script.mainpage.js') }}"></script>

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
                content.classList.remove('show');
                content.classList.remove('show-block');
            })

            const contentId = tab.getAttribute('content-id');
            const contentSelected = document.getElementById(contentId);


            if (contentId === 'services') {
                // contentSelected.classList.remove('show'); // Remove any existing 'show' class
                contentSelected.classList.add('show');
                contentSelected.classList.add('show-block');
            } else {
                contentSelected.classList.remove('show-block'); // Remove any existing 'show-block' class
                contentSelected.classList.add('show');
            }

        }
    </script>
@stop
