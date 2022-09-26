<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
  public function home()
  {
    $page = Page::where('is_home', 1)->with('pageSections.section.PageSubSections', 'pageSections.subsection.PageElements', 'pageSections.PageElements.element')->first();
    $data['posts'] = Post::all();
    return view('frontend.pages.cms', compact('page', 'data'));
  }

  public function index()
  {
    $pages = Page::all();
    return view('backend.pages.index', compact('pages'));
  }

  public function search(Request $request)
  {
    $s = $request->GET('s');
    $posts = Post::where('title', 'LIKE', '%' . $s . '%')->orWhere('content', 'LIKE', '%' . $s . '%')->get();
    $posts->count = $posts->count();
    $posts->title = $s;
    return view('frontend.posts.search', compact('posts'));
  }

  public function show($slug)
  {
    $page = Page::where('slug', $slug)->where('is_disabled', 0)->where('is_home', 0)->with('pageSections.section.PageSubSections', 'pageSections.subsection.PageElements', 'pageSections.PageElements')->first();
    if (isset($page)) {
      return view('frontend.pages.cms', compact('page'));
    } else {
      abort(404);
    }
  }
}
