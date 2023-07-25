<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\NearbyTests;
use App\Models\Package;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
  public function home()
  {
      $packages = Package::where('show_frontend', 1)->get();
      return view('frontend.home.index', compact('packages'));
  }

    public function getPackages(Request $request)
    {
        $packages = Package::whereId($request->packageId)->first();
        $packageImg = asset("public" . \Illuminate\Support\Facades\Storage::url($packages->thumbnail));
        $packages['package_img'] = "<img class='img-responsive-card' id='package_img' src='$packageImg'>";
        $view = view('frontend.home.ajax_res', compact('packages'))->render();
        return response()->json(['success' => true, 'package' => $packages,'html_view'=>$view]);
    }

    public function selectPackage(Request $request)
    {
        $package = Package::whereId($request->pkgId)->first();
        $selectpackageImg = asset("public" . \Illuminate\Support\Facades\Storage::url($package->thumbnail));
        $package['select_package_img'] = "<img class='img-responsive-card' id='package_img' src='$selectpackageImg'>";
        return response()->json(['success' => true, 'selectPackage' => $package]);
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


  public function getNearby()
  {

    $lat = floatval(24.91085391641344);
    $lng = floatval(67.07264835781206);
    $radius = 100000;

    $deliveries = Delivery::with(['user_package.user' => function ($query) use ($lat, $lng) {
      $distance = DB::raw("*, ( 6371 * acos( cos( radians($lat) ) * cos( radians( delivery_lat ) ) * cos( radians( delivery_long ) - radians($lat) ) + sin( radians($lat) ) * sin( radians( delivery_lat ) ) ) ) AS distance");
      $query->select($distance)->orderBy('distance', 'ASC');
    }])
      ->where('status', 'Pending')
      ->get()->sortBy('user_package.user.distance');

    $half = ceil($deliveries->count() / 3);
    $devided = $deliveries->chunk($half);
    dd($devided);
  }
}
