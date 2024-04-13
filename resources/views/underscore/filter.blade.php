<div class="controls mb-3">
    <select class="col-md-3" id="{{ $status }}_branch_select" onchange="getBranch(this)"
        data-status="{{ $status }}">
        <option value="0">All Branches</option>
        @foreach ($branch_list as $branch)
            <option value="{{ $branch->id }}">{{ $branch->branch }}</option>
        @endforeach
    </select>
    <select class="col-md-3" id="{{ $status }}_category_select" onchange="getCategory(this)"
        data-status="{{ $status }}">
        <option value="0">All Categories</option>
        @foreach ($student_categories_list as $student_category)
            <option value="{{ $student_category->cat_id }}">{{ $student_category->category }}</option>
        @endforeach
    </select>
    <select class="col-md-3" id="{{ $status }}_year_select" onchange="getYear(this)"
        data-status="{{ $status }}">
        <option value="0">All Years</option>
        <?php echo implode('', array_map(fn($year) => "<option>$year</option>", range(date('Y'), date('Y') + 10))); ?>
    </select>
    <button id="refresh" class="btn btn-warning" onclick="resetFilter('{{ $status }}')">Refresh</button>

</div>
