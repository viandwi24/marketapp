<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $categories = Product::query();
            return DataTables::of($categories)
                ->make();
        }

        return view('pages.admin.product');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $store = Product::create($request->only('name', 'description', 'price'));

        return response([
            'status' => 'success',
            'message' => 'Create Product ' . $request->name . ' Success.',
            'data' => $store
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $update = $product->update($request->only('name', 'description', 'price'));

        return response([
            'status' => 'success',
            'message' => 'Update Product ' . $request->name . ' Success.',
            'data' => $update
        ]);
    }

    public function destroy(Product $product)
    {
        $delete = $product->delete();

        return response([
            'status' => 'success',
            'message' => 'Delete Product ' . $product->name . ' Success.',
            'data' => $product
        ]);
    }
}
