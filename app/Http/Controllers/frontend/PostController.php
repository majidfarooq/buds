<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $recent_posts = Post::latest()->get();
        $posts = Post::with('admin', 'category')->get();
        return view('frontend.posts.index', compact('posts', 'tags', 'categories', 'recent_posts'));
    }

    public function show($slug)
    {
        $data['categories'] = Category::get();
        $data['post'] = $post = Post::where('slug', $slug)->with('admin', 'category', 'tags')->first();
        return view('frontend.posts.show', compact('data'));
    }

    public function author($name)
    {
        $author = Admin::where('name', $name)->with('posts')->first(['id', 'name', 'image']);
        return view('frontend.authors.index', compact('author'));
    }

    public function showTag($slug)
    {
        $categories = Category::get();
        $tag = Tag::where('slug', $slug)->with('posts')->first();
        return view('frontend.tags.index', compact('tag', 'categories'));
    }

    public function showCategory($slug)
    {
        $categories = Category::get();
        $category = Category::where('slug', $slug)->with('posts')->first();
        return view('frontend.categories.index', compact('category', 'categories'));
    }
}
