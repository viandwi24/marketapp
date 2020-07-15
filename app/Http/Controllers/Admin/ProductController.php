<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Select2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $categories = Product::with('category', 'image');
            return DataTables::of($categories)
                ->make();
        }

        $categories = (new Select2((Category::all()), ['name']));
        return view('pages.admin.product', compact('categories'));
    }

    public function store(Request $request)
    {
        // return $request->file('image');

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|json',
            'image' => 'required|image',
        ]);

        // $image = $request->file('image');
        // return [
        //     "name" => $image->getClientOriginalName(),
        //     "extension" => $image->getClientOriginalExtension(),
        //     "mime" => $image->getClientMimeType()
        // ];

        $categories = Category::whereIn('id', json_decode($request->category))->get();
        $store = null;
        DB::transaction(function () use ($request, $categories, &$store) {
            // 
            $image = $request->file('image');
            $image_name = Str::random(26) . Carbon::now()->timestamp . ".{$image->getClientOriginalExtension()}";
            $image->move("images/products", $image_name);

            // store db
            $store = Product::create($request->only('name', 'description', 'price'));
            $store->category()->sync($categories->pluck('id'));
            $store->image()->create(['filename' => $image_name]);
        });

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
            'price' => 'required|numeric',
            'category' => 'required|array'
        ]);

        $categories = Category::whereIn('id', $request->category)->get();
        DB::transaction(function () use ($request, $categories, &$product) {
            $product->update($request->only('name', 'description', 'price'));
            $product->category()->sync($categories->pluck('id'));
        });

        return response([
            'status' => 'success',
            'message' => 'Update Product ' . $request->name . ' Success.',
            'data' => $product
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
