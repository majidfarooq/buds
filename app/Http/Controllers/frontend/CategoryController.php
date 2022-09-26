<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', null)->get();
        return view('frontend.categories.index', compact('categories'));
    }

    public function subCategories(Category $category)
    {
        $categories = Category::where('parent_id', $category->id)->get();
        $cat = Category::where('parent_id', null)->get();
        return view('frontend.categories.sub_categories', compact('categories', 'cat'));
    }

    public function subCategory(Category $category)
    {
        $cat = Category::where('parent_id', null)->get();
        $category = Category::where('id', $category->id)->get();
        return view('frontend.categories.sub_category', compact('category', 'cat'));
    }
}
