<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use MercurySeries\Flashy\Flashy;


class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');
            } else {
                $search = '';
            }
            $columns = array(
                0 => 'id',
                1 => 'title',
                2 => 'content',
                3 => 'thumbnail',
                4 => 'created_at',
                5 => 'id',
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $totalData = Post::withTrashed()->when($search != '', function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })->count();
            $posts = Post::withTrashed()->when($search != '', function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })->offset($start)->limit($limit)->orderBy($order, $dir)->get();
            $totalFiltered = $totalData;
            $data = array();
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $edit = route('admin.posts.edit', $post->slug);
                    $destroy = route('admin.posts.destroy', $post->id);
                    $restore = route('admin.posts.restore', $post->id);
                    $image = (isset($post->thumbnail) ? asset($post->thumbnail) : asset('/public/storage/placeholder.jpg'));
                    $csrf = csrf_token();
                    $nestedData['id'] = $post->id;
                    $nestedData['title'] = Str::limit($post->title, 20);
                    $nestedData['content'] = Str::limit($post->content, 20);
                    $nestedData['thumbnail'] = "<img width='100' src='{$image}'>";
                    $nestedData['created_at'] = date('j M Y h:i a', strtotime($post->created_at));
                    $nestedData['action'] = '';

                    if ($post->trashed()) {
                        $nestedData['action'] .= "<form action='{$restore}' method='POST'>
            <input type='hidden' value='{$csrf}' name='_token'>
            <button type='submit' data-title='Restore' class='btn btn-success btn-circle'>
            <i class='fas fa-trash-restore-alt'></i>
            </button>
            </form>";
                    } else {
                        $nestedData['action'] .= "<form action='{$destroy}' method='POST'>
            <input type='hidden' name='_method' value='delete' />
            <input type='hidden' value='{$csrf}' name='_token'>
            <button type='submit' data-title='Disable' class='btn btn-danger btn-circle'>
            <i class='fas fa-trash-alt'></i>
            </button>
            </form>";
                    }

                    $nestedData['action'] .= "<form action='{$edit}' method='post'>
            <input type='hidden' value='{$post->id}' name='pageId'>
            <input type='hidden' value='{$csrf}' name='_token'>
            <button type='submit' data-title='Edit' class='btn btn-info btn-circle'>
            <i class='fas fa-edit'></i></button>
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
            return view('backend.posts.index');
        }
    }

    public function create()
    {
        $tags = Tag::orderBy('created_at', 'DESC')->get();
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return view('backend.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'text_content' => 'required',
            'thumbnail' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->hasFile('thumbnail') != null) {
                $imageFile = sprintf('post_%s.jpg', random_int(1, 1000));
                $path = $request->file('thumbnail')->storeAs('/posts', $imageFile, 'public');
                $content = '/public/storage/' . $path;
            } else {
                $content = '';
            }
            $post = Post::create([
                "title" => $request->title,
                "admin_id" => auth::user()->id,
                "cat_id" => $request->category_id,
                "meta_title" => $request->meta_title,
                "meta_keyword" => $request->meta_keywords,
                "meta_description" => $request->meta_description,
                "content" => $request->text_content,
                "thumbnail" => $content,
            ]);
            $tags = explode(',', $request->tags);
            $post_tags = Tag::whereIn('name', $tags)->get();
            foreach ($post_tags as $post_tag) {
                $post->tags()->attach($post_tag->id);
            }
            Flashy::success("Post Created Successful.");
            return redirect()->route('admin.posts.index')->with('success', 'Post Created Successful.');
        }
    }

    public function edit($slug)
    {
        $tags = Tag::orderBy('created_at', 'DESC')->get();
        $post = Post::withTrashed()->where('slug', $slug)->with('category', 'tags')->first();
        $posttags = [];
        if (isset($post->tags)) {
            foreach ($post->tags as $tag) {
                $posttags[isset($tag['id']) ? $tag['id'] : ''] = isset($tag['name']) ? $tag['name'] : '';
            }
            $post_tags = implode(', ', $posttags);
        }
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return view('backend.posts.edit', compact('post', 'categories', 'tags', 'post_tags'));
    }

    public function update(Request $request)
    {
        $post = Post::withTrashed()->where('id', $request->postId)->first();
        if ($request->hasFile('thumbnail') != null) {
            $imageFile = sprintf('post_%s.jpg', random_int(1, 1000));
            $path = $request->file('thumbnail')->storeAs('/posts', $imageFile, 'public');
            $content = '/public/storage/' . $path;
        } else {
            $content = $post->thumbnail;
        }
        $post->update([
            'title' => $request->title,
            "cat_id" => $request->category_id,
            "meta_title" => $request->meta_title,
            "meta_keyword" => $request->meta_keywords,
            "meta_description" => $request->meta_description,
            'content' => $request->text_content,
            'thumbnail' => $content,
        ]);

        $post->tags()->detach();
        $tags = explode(',', $request->tags);
        $post_tags = Tag::whereIn('name', $tags)->get();
        foreach ($post_tags as $post_tag) {
            $post->tags()->attach($post_tag->id);
        }


        if ($post) {
            return redirect()->route('admin.posts.index')->with('success', 'Post Updated Successful.');
        } else {
            return redirect()->route('admin.posts.index')->with('error', 'Something wrong!.');
        }
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->whereId($id)->first();
        if ($post->restore()) {
            return redirect()->back()->with(['success' => 'Post Restored Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }

    public function destroy($id)
    {
        $post = Post::whereId($id)->first();
        if ($post->delete()) {
            return redirect()->back()->with(['success' => 'Post Deleted Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }
}
