<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('products', 'parent')->withCount('products')->orderBy('id', 'desc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate input
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'parent_id' => 'nullable||exists:categories,id'
        ]);
        //upload the file
        $new_image = rand() . rand() . time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/images'), $new_image);

        //save data to database
        Category::create([
            'name' => $request->name,
            'image' => $new_image,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.categories.index')->with('msg', 'Category Created')->with('type', 'success');
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
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_id')->where('parent_id', '<>', $category->id)->get();
        return view('admin.categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate input
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'parent_id' => 'nullable||exists:categories,id'
        ]);

        $category = Category::findorfail($id);
        $new_image = $category->image;
        //upload the file
        if ($request->hasFile('image')) {
            $new_image = rand() . rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/images'), $new_image);
        }
        //save data to database
        $category->update([
            'name' => $request->name,
            'image' => $new_image,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.categories.index')->with('msg', 'Category Updeted')->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        //delete image
        if (file_exists(public_path('uploads/images/' . $category->image))) {
            File::delete(public_path('uploads/images/' . $category->image));
        }
        //set parent id to null
        Category::where('parent_id', $category->id)->update(['parent_id' => null]);
        //delete item
        $category->delete();

        return redirect()->route('admin.categories.index')->with('msg', 'Category deleted Successfully')->with('type', 'danger');
    }
}
