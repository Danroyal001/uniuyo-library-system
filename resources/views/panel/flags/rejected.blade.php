<div class="module">
    <div class="module-body">
        @include('underscore.filter', ['status' => 'rejected'])

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Roll Number</th>
                    <th>Branch</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="rejected-table">
                <tr class="text-center">
                    <td colspan="99"><i class="icon-spinner icon-spin"></i></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" name="" id="branches_list" value="{{ json_encode($branch_list) }}">
<input type="hidden" name="" id="student_categories_list" value="{{ json_encode($student_categories_list) }}">
<input type="hidden" id="_token" data-form-field="token" value="{{ csrf_token() }}">
