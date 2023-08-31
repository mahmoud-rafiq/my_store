<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->OrderBydesc('id')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();
        $product = new Product();
        return view('admin.products.create', compact('categories' ,'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required'
        ]);
        //store image
        $new_image = rand() . rand() . time() . $request->file('image')->getClientOriginalName();

        $new_image = str_replace(' ', '', $new_image);

        $new_image = strtolower($new_image);

        $request->file('image')->move(public_path('uploads/images/products'), $new_image);

        //save data to database
        Product::create([
            'name' => $request->name,
            'image' => $new_image,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id
        ]);
        return redirect()->route('admin.products.index')->with('msg', 'Product Added Successfully')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select(['id', 'name'])->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required'
        ]);

        $product = Product::findOrFail($id);
        $new_image = $product->image;

        if ($request->hasFile('image')) {
            //store image
            $new_image = rand() . rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/images/products'), $new_image);
        }

        //save data to database
        $product->update([
            'name' => $request->name,
            'image' => $new_image,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id
        ]);
        return redirect()->route('admin.products.index')->with('msg', 'Product Updeted Successfully')->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::findOrFail($id);

         //delete image
         if (file_exists(public_path('uploads/images/products/' . $product->image))) {
            File::delete((public_path('uploads/images/products/' . $product->image)));
        }
        //delete item
        $product->delete();

        return redirect()->route('admin.products.index')->with('msg', 'Product deleted Successfully')->with('type', 'danger');
    }
}
