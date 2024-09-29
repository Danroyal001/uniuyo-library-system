@extends('layout.index')

@section('content')
    @include('panel.settings-tabs')
@endsection

@section('custom_bottom_script')
    <script type="text/javascript">
        var branches_list = $('#branches_list').val(),
            categories_list = $('#student_categories_list').val(),
            _token = $('#_token').val();
    </script>
    <script type="text/javascript" src="{{ asset('static/custom/js/script.settings_1.js') }}"></script>
    <div class="" style="visiblity: hidden">
        <script type="text/template" id="branch_show">
            @include('underscore.all_branches')
        </script>
        <script type="text/template" id="category_show" >
            @include('underscore.all_categories')
        </script>
        {{-- <script type="text/template" id="rejectstudents_show" >
            @include('underscore.rejectstudents_show')
        </script>
        <script type="text/template" id="blockstudents_show" >
            @include('underscore.blockstudents_show')
        </script> --}}
    </div>
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
