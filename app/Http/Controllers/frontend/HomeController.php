<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function index()
    {
        $cat = Category::where('parent_id', null)->get();
        $posts = Post::take(3)->orderBy('created_at', 'DESC')->get();
        return view('frontend.home.home', compact('cat', 'posts'));
    }
}
