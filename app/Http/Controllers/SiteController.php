<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index()
    {
        $main_categories = Category::with('children')->whereNull('parent_id')->take(11)->get();

        $latest_products = Product::with('category')->orderByDesc('created_at')->limit(3)->get();
        // dd($latest_products);
        return view('site.index', compact('main_categories', 'latest_products'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);

        return view('site.category', compact('category'));
    }

    public function product($id)
    {
        $product = Product::with('reviews')->findOrFail($id);

        return view('site.product', compact('product'));
    }

    public function shop()
    {
        $products = Product::paginate(8);
        return view('site.shop', compact('products'));
    }

    public function add_review(Request $request)
    {

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'comment' => $request->comment,
            'star' => $request->star,
        ]);

        return redirect()->back();
    }
}
