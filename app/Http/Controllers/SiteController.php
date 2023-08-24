<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SiteController extends Controller
{
public function index()
{
    $main_categoris = Category::whereNull('parent_id')->take(11)->get();
    return view('site.index', compact('main_categoris'));
}
}
