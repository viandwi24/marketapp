<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $categories = Category::query();
            return DataTables::of($categories)
                // ->addColumn('action', function () { return ''; })
                ->make();
        }

        return view('pages.admin.category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $store = Category::create($request->only('name', 'description'));

        return response([
            'status' => 'success',
            'message' => 'Create Category ' . $request->name . ' Success.',
            'data' => $store
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $update = $category->update($request->only('name', 'description'));

        return response([
            'status' => 'success',
            'message' => 'Update Category ' . $request->name . ' Success.',
            'data' => $update
        ]);
    }

    public function destroy(Category $category)
    {
        $delete = $category->delete();

        return response([
            'status' => 'success',
            'message' => 'Delete Category ' . $category->name . ' Success.',
            'data' => $category
        ]);
    }
}
