<div class="module">
    <div class="module-body">
        <form class="form-horizontal row-fluid">
            <div class="control-group">
                <label class="control-label">Student Category</label>
                <div class="controls">
                    <input type="text" id="student_category" name="category"
                        placeholder="Enter the category of the book here..." class="span8">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="category_id" id="student_category_id">
                    <input type="hidden" name="status" value="category">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Max Allow</label>
                <div class="controls">
                    <input type="number" id="max_allow" name="max_allowed" placeholder="Enter the max allow value"
                        class="span8">
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="button" class="btn btn-success" onclick="handleFormSubmition(this)"
                        id="addStudentCategory">Add Student
                        Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="module">
    <div class="module-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Max Allowed</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody id="category-table">
                <tr class="text-center">
                    <td colspan="12">Loading...</td>
                </tr>
            </tbody>
            {{-- <tbody>
                @foreach ($student_category as $student_category)
                    <tr>
                        <td>{{ $student_category->cat_id }}</td>
                        <td>{{ $student_category->category }}</td>
                        <td>{{ $student_category->max_allowed }}</td>
                        <td>
                            <div class="btn btn-group">
                                <a href=""><i class="icon-edit"></i></a>
                                <a href="#" data-toggle="modal"
                                    data-target="#deleteCategory{{ $student_category->cat_id }}"><i
                                        class="icon-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteCategory{{ $student_category->cat_id }}" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Student Category
                                    </h5>

                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('student.destroy', $student_category->cat_id) }}"
                                        method="Post">
                                        @csrf
                                        @method('Delete')
                                        <p>Are you sure you want to delete this
                                            ({{ $student_category->category }})
                                            Student Category ? </p>
                                        <input type="hidden" name="category" id="category"
                                            value="{{ $student_category->category }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                @endforeach

            </tbody> --}}
        </table>
    </div>
</div>
