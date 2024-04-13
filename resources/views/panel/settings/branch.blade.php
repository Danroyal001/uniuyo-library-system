<div class="module">
    <div class="module-body column">
        <form class="form-horizontal row-fluid">
            <div class="control-group">
                <label class="control-label">Branch Name</label>
                <div class="controls">
                    <input type="text" id="branch" name="branch" placeholder="Enter branch here..." class="span8">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="branch_id" id="branch_id">
                    <input type="hidden" name="status" value="branch">
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="button" class="btn btn-success" onclick="handleFormSubmition(this)"
                        id="addBranch">Add Branch</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="module">
    <div class="module-body">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($branches as $branch)
                    <tr>
                        <td>{{ $branch->id }}</td>
                        <td>{{ $branch->branch }}</td>
                        <td>
                            <div class="btn btn-group">
                                <a href=""><i class="icon-edit"></i></a>

                                <a href="#" data-toggle="modal" data-target="#deleteBranch{{ $branch->id }}"><i
                                        class="icon-trash"></i></a>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteBranch{{ $branch->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Branch</h5>

                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('student.destroy', $branch->id) }}" method="Post">
                                        @csrf
                                        @method('Delete')
                                        <p>Are you sure you want to delete this ({{ $branch->branch }})
                                            Branch ? </p>
                                        <input type="hidden" name="branch" id="branch"
                                            value="{{ $branch->branch }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </tbody> --}}
            <tbody id="branch-table">
                <tr class="text-center">
                    <td colspan="12">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
