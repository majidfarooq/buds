<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;
use phpDocumentor\Reflection\Types\Null_;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 => 'id', 1 => 'name', 2 => 'description', 3 => 'image', 4 => 'created_at', 5 => 'id'
            );
            $totalData = Category::count();
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $categories = Category::offset($start)->limit($limit)->orderBy($order, $dir)->get();
            } else {
                $search = $request->input('search.value');
                $categories = Category::where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->offset($start)->limit($limit)->orderBy($order, $dir)->get();
                $totalFiltered = Category::where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->count();
            }
            $data = array();
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $edit = route('admin.categories.edit', $category->slug);
                    $image = (isset($category->image) ? asset($category->image) : asset('/public/storage/placeholder.jpg'));
                    $csrf = csrf_token();
                    $nestedData['id'] = $category->id;
                    $nestedData['name'] = $category->name;
                    $nestedData['description'] = $category->description;
                    $nestedData['image'] = "<img width='100' src='{$image}'>";
                    $nestedData['created_at'] = date('j M Y h:i a', strtotime($category->created_at));
                    $nestedData['action'] = '';
                    $nestedData['action'] .= "<form action='{$edit}' method='POST'><input type='hidden' value='{$csrf}' name='_token'> <button type='submit' data-title='Edit' class='btn btn-success btn-circle'>
      <i class='fas fa-pencil-alt'></i> </button>
      </form>";
                    $data[] = $nestedData;
                }
                $json_data = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );
                echo json_encode($json_data);
            }
        } else {
            return view('backend.categories.index');
        }
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)->get();
        return view('backend.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->hasFile('image') == null) {
                $content = '';
            } else {
                $imageFile = sprintf('category_%s.jpg', random_int(1, 1000));
                $path = $request->file('image')->storeAs('/categories', $imageFile, 'public');
                $content = '/public/storage/' . $path;
            }
            $category = Category::create([
                "name" => $request->name,
                "description" => $request->description,
                "parent_id" => (isset($request->parent_id) ? $request->parent_id : null),
                "image" => $content,
            ]);

            Flashy::success("Category Created Successful.");
            return redirect()->route('admin.categories.index')->with('success', 'Category Created Successful.');
        }
    }

    public function show($id)
    {
        $category = Category::whereId($id)->first();
        return view('backend.categories.show', compact('category'));
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->with('parent')->first();
        $categories = Category::where('parent_id', null)->get();
        return view('backend.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if ($request->hasFile('image') == null) {
            $content = $category->image;
        } else {
            $imageFile = sprintf('category_%s.jpg', random_int(1, 1000));
            $path = $request->file('image')->storeAs('/categories', $imageFile, 'public');
            $content = '/public/storage/' . $path;
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->image = $content;
        if ($category->save()) {
            return redirect()->route('admin.categories.index')->with('success', 'Category Updated Successful.');
        } else {
            return redirect()->route('admin.categories.index')->with('error', 'Something wrong!.');
        }
    }
}
