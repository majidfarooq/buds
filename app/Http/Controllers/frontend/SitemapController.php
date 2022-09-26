<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $data = [];
        $data['pages'] = Page::where('is_home', 0)->orderBy('created_at', 'desc')->get();
        $data['posts'] = Post::orderBy('created_at', 'desc')->get();
        $data['categories'] = Category::orderBy('created_at', 'desc')->get();
        $data['tags'] = Tag::orderBy('created_at', 'desc')->get();
        return response()->view('frontend.sitemap.index', ['data' => $data])->header('Content-Type', 'text/xml');
    }
}
