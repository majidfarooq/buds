<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function show(Menu $menu)
    {
        $data['recent'] = Page::where('is_home', 0)->orderBy('id', 'DESC')->get();
        $data['menu_state'] = Menu::where('slug', $menu->slug)->with('MenuItem.submenu')->first();
        $data['pages'] = Page::where('is_home', 0)->orderBy('id', 'DESC')->get();
        return view('backend.menu.add', $data);
    }

    public function listMenu(Request $request)
    {
        $page_arr = $request['page_arr'];
        $menuId = $request['menuId'];
        $content = '';
        foreach ($page_arr as $key => $value) {
            if (isset($value)) {
                $page = Page::where('id', $value)->first();
                $content .= '
    <li data-type="cms" data-parent_id="0" data-url="' . $page->slug . '" data-id="0" data-page_id="' . $page->id . '">
    <a href="javascript:void(0)" style="display: inline-block;" class="ui-sortable-handle" data-editable>' . $page->title . '</a>
    <i onclick="removeMenuItem(this)" class="fa fa-trash push-right" aria-hidden="true" style="float:  right;margin-right: 15px;margin-top: 15px;">
    </i>
    <input type="hidden" name="title" id="title" value="' . $page->title . '">
    </li>';
            }
        }
        return response()->json(['content' => $content,]);
    }

    public function store(Request $request)
    {
        $content = $request['content'];
        $final_arr = $request['final_arr'];
        $menuId = $request['menuId'];
        //  MenuItem::where('menu_id',$menuId)->delete();
        //  dd($request->all());
        // all menuitems delete
        if (isset($final_arr)) {
            $cntr = 1;
            foreach ($final_arr as $key => $value) {
                if ($value['id'] == 0) {
                    $parent = new MenuItem();
                } else {
                    $parent = MenuItem::find($value['id']);
                }
                $parent->title = $value['title'];
                $parent->url = $value['url'];
                $parent->page_type = $value['type'];
                $parent->page_id = $value['page_id'];
                $parent->menu_id = $value['menu_id'];
                $parent->position = $cntr;
                $parent->parent_id = $value['parent_id'];
                $parent->save();
                $parentId = $parent->id;

                if (isset($value['child']) && $value['child'] > 0) {
                    foreach ($value['child'] as $chld) {
                        if ($chld['id'] == 0) {
                            $parent = new MenuItem();
                        } else {
                            $parent = MenuItem::find($chld['id']);
                        }
                        $parent->title = $chld['title'];
                        $parent->url = $chld['url'];
                        $parent->page_type = $chld['type'];
                        $parent->page_id = $chld['page_id'];
                        $parent->menu_id = $chld['menu_id'];
                        $parent->position = $cntr;
                        $parent->parent_id = $parentId;
                        $parent->save();
                    }
                }

                $cntr++;
            }
        }

        $menu_state = Menu::where('id', $menuId)->first();
        if (isset($content)) {
            $menu_state->content = $content;
            $menu_state->update();
        } else {
            $menu_state->content = "<p id='status'>No item available. The list is empty</p>";
            $menu_state->update();
            MenuItem::where('menu_id', $menuId)->delete();
        }

        return 'ok';
    }

    public function delete(Request $request)
    {
        $MenuItem = MenuItem::whereId($request->id)->first();
        if ($MenuItem->delete()) {
            return response()->json(['success' => 'Menu Item Deleted successfully']);
        } else {
            return response()->json(['error' => 'something wrong']);
        }
    }
}
