<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentCategory; // Fix the import statement for StudentCategory model
use Illuminate\Support\Arr;

class SettingController extends Controller
{
    public function renderSetting(Request $request)
    {
        if ($request->ajax()) {
            return $this->getSettingByStatus($request); // Return the result of getSettingByStatus
        } else {
            return view('panel.addsettings');
        }
    }

    public function storeSetting(Request $request) // Fix the method name to follow Laravel convention
    {
        if ($request->status === 'category') { // Use has method to check if the 'category' field exists
            $studentCategory = StudentCategory::updateOrCreate(['cat_id' => $request->category_id], Arr::except($request->all(), ['category_id']));
            return $studentCategory ? 'Student Category saved successfully!' : 'Failed to save student category.';
        } elseif ($request->status === 'branch') { // Use has method to check if the 'branch' field exists
            $branch = Branch::updateOrCreate(['id' => $request->branch_id], $request->all());
            return $branch ? 'School Branch saved successfully!' : 'Failed to save school branch.';
        }
    }

    function deleteSetting(Request $request, $id)
    {
        if ($request->status === 'category') {
            StudentCategory::find($id)->delete();
            return 'Category deleted successfully!';
        } else {
            Branch::find($id)->delete();
            return 'Branch deleted successfully!';
        }
    }

    protected function getSettingByStatus(Request $request)
    {
        $status = $request->status;

        return match ($status) {
            'branch' => $this->getBranchData(),
            'category' => $this->getCategoryData(),
            default => 'Invalid status', // Handle invalid status
        };
    }

    protected function getBranchData()
    {
        $branches = Branch::select('id', 'branch', 'created_at')->get(); // Fix the column name 'branch' in the select statement
        return $branches->isEmpty() ? 'No Result Found' : $branches;
    }

    protected function getCategoryData()
    {
        $categories = StudentCategory::select('cat_id', 'category', 'created_at', 'max_allowed')->get(); // Fix the column name 'branch' to 'name'
        return $categories->isEmpty() ? 'No Result Found' : $categories;
    }
}
