<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;

class TagController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 => 'id',
                1 => 'name',
                2 => 'description',
                3 => 'image',
                4 => 'created_at',
                5 => 'id',
            );
            $totalData = Tag::count();
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $tags = Tag::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');
                $tags = Tag::where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = Tag::where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->count();
            }
            $data = array();
            if (!empty($tags)) {
                foreach ($tags as $tag) {
                    $edit = route('admin.tags.edit', $tag->slug);
                    $image = (isset($tag->image) ? asset($tag->image) : asset('/public/storage/placeholder.jpg'));
                    $csrf = csrf_token();
                    $nestedData['id'] = $tag->id;
                    $nestedData['name'] = $tag->name;
                    $nestedData['description'] = $tag->description;
                    $nestedData['image'] = "<img width='100' src='{$image}'>";
                    $nestedData['created_at'] = date('j M Y h:i a', strtotime($tag->created_at));
                    $nestedData['action'] = '';
                    $nestedData['action'] .= "<form action='{$edit}' method='POST'>
            <input type='hidden' value='{$csrf}' name='_token'>
            <button type='submit' data-title='Edit' class='btn btn-success btn-circle'>
            <i class='fas fa-pencil-alt'></i>
            </button>
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
            return view('backend.tags.index');
        }
    }

    public function create()
    {
        return view('backend.tags.create');
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
                $imageFile = sprintf('tag_%s.jpg', random_int(1, 1000));
                $path = $request->file('image')->storeAs('/tags', $imageFile, 'public');
                $content = '/public/storage/' . $path;
            }

            $tag = Tag::create([
                "name" => $request->name,
                "description" => $request->description,
                "image" => $content,
            ]);
            Flashy::success("Tag Created Successful.");
            return redirect()->route('admin.tags.index')->with('success', 'Tag Created Successful.');
        }
    }

    public function show($id)
    {
        $tag = Tag::whereId($id)->first();
        return view('backend.tags.show', compact('tag'));
    }

    public function edit($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        return view('backend.tags.edit', compact('tag'));
    }

    public function update(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($request->hasFile('image') == null) {
            $content = $tag->image;
        } else {
            $imageFile = sprintf('tag_%s.jpg', random_int(1, 1000));
            $path = $request->file('image')->storeAs('/tags', $imageFile, 'public');
            $content = '/public/storage/' . $path;
        }
        $tag->name = $request->name;
        $tag->description = $request->description;
        $tag->image = $content;
        if ($tag->save()) {
            return redirect()->route('admin.tags.index')->with('success', 'Tag Updated Successful.');
        } else {
            return redirect()->route('admin.tags.index')->with('error', 'Something wrong!.');
        }
    }
}
