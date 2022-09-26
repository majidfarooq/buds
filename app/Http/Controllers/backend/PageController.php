<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Element;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\PageElements;
use App\Models\PageElementSection;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {

      $columns = array(
        0 => 'id',
        1 => 'title',
        2 => 'deleted_at',
        3 => 'created_at',
        4 => 'id',
      );
      $totalData = Page::withTrashed()->count();
      $totalFiltered = $totalData;
      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');
      if (empty($request->input('search.value'))) {
        $pages = Page::withTrashed()->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');
        $pages = Page::withTrashed()->where('id', 'LIKE', "%{$search}%")
          ->orWhere('title', 'LIKE', "%{$search}%")
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
        $totalFiltered = Page::withTrashed()->where('id', 'LIKE', "%{$search}%")
          ->orWhere('title', 'LIKE', "%{$search}%")
          ->count();
      }
      $data = array();
      if (!empty($pages)) {
        foreach ($pages as $page) {
          $edit = route('admin.pages.edit', $page->slug);
          $disable = route('admin.pages.disable', $page->id);
          $destroy = route('admin.pages.destroy', $page->id);
          $restore = route('admin.pages.restore', $page->id);
          $csrf = csrf_token();

          $nestedData['id'] = $page->id;
          $nestedData['title'] = $page->title;
          $nestedData['deleted_at'] = '';
          if ($page->trashed()) {
            $nestedData['deleted_at'] .= "Deleted";
          } else {
            $nestedData['deleted_at'] .= "Publish";
          }
//              $nestedData['body'] = substr(strip_tags($page->body),0,50)."...";
          $nestedData['created_at'] = date('j M Y h:i a', strtotime($page->created_at));
          $nestedData['action'] = '';
          if ($page->trashed()) {
            $nestedData['action'] .= "<form action='{$restore}' method='POST'>
                                              <input type='hidden' value='{$csrf}' name='_token'>
                                              <button type='submit' data-title='Restore' class='btn btn-success btn-circle'>
                                              <i class='fas fa-ban'></i>
                                              </button>
                                              </form>";
          } else {
            $nestedData['action'] .= "<form action='{$disable}' method='POST'>
                                              <input type='hidden' name='_method' value='delete' />
                                              <input type='hidden' value='{$csrf}' name='_token'>
                                              <button type='submit' data-title='Disable' class='btn btn-danger btn-circle'>
                                              <i class='fas fa-trash-alt'></i>
                                              </button>
                                              </form>";
          }

          $nestedData['action'] .= "<form action='{$destroy}' method='POST'>
                                      <input type='hidden' name='_method' value='delete' />
                                      <input type='hidden' value='{$csrf}' name='_token'>
                                      <button type='submit' data-title='Delete' class='btn btn-danger btn-circle'>
                                      <i class='fas fa-trash-alt'></i>
                                      </button>
                                    </form>";

          $nestedData['action'] .= "<form action='{$edit}' method='post'>
                                          <input type='hidden' value='{$page->id}' name='pageId'>
                                          <input type='hidden' value='{$csrf}' name='_token'>
                                          <button type='submit' data-title='Edit' class='btn btn-info btn-circle'>
                                          <i class='fas fa-edit'></i></button>
                                          </form>";
//                $nestedData['action'] .= "<a data-title='Show' href='{$show}' class='btn btn-success btn-circle'><i class='fas fa-eye'></i></a>";
          $data[] = $nestedData;

        }
      }
      $json_data = array(
        "draw" => intval($request->input('draw')),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
      );

      echo json_encode($json_data);


    } else {
      return view('backend.pages.index');
    }
  }

  public function create(Request $request)
  {
    $isPage = 0;
    if (isset($request->pageId)) {
      $pageId = $request->pageId;
      $isPage = 1;
    } else {
      $page = Page::create([
        'title' => 'New page',
        'is_disabled' => 0,
        'banner' => '/public/storage/placeholder.jpg',
      ]);
      $pageId = $page->id;
    }
    $page = Page::withTrashed()->whereId($pageId)->first();
    $page->isPage = $isPage;
    $type = DB::select(DB::raw("SHOW COLUMNS FROM pages WHERE Field = 'page_type'"))[0]->Type;
    preg_match_all("/'([^']+)'/", $type, $matches);
    $page->types  = $matches[1];
    if ($page) {
      return view('backend.pages.create', compact('page'));
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function edit(Page $page)
  {
    $pageId = $page->id;
    $page = Page::whereId($pageId)->with('pageElements.element.fields', 'pageElements.content')->first();
    $element = Element::with('fields')->get();
    return view('backend.pages.edit', compact('page'));
  }

  public function update(Request $request)
  {
    $data = $request->except(['_method', '_token']);
    $pageId = $data['pageId'];
    $page = Page::withTrashed()->whereId($pageId)->first();
    $page->title = $data['title'];
    $page->page_type = $data['page_type'];
    $page->meta_title = $data['meta_title'];
    $page->meta_keywords = $data['meta_keywords'];
    $page->meta_description = $data['meta_description'];
    $page->page_css = $data['page_css'];
    $page->page_script = $data['page_script'];
    if ($request->hasFile('banner') != null) {
      $extension = $request->file('banner')->extension();
      $image = sprintf('banner_%s' . '.' . $extension, random_int(1, 1000));
      $path = $request->file('banner')->storeAs('/banner', $image, 'public');
      $content = '/public/storage/' . $path;
    } else {
      $content = $page->banner;
    }

    if ($data['is_home'] == "1") {
      Page::where('is_home', 1)->whereNotIn('id', [$pageId])->update(['is_home' => 0]);
      $is_home = 1;
    } else {
      $is_home = 0;
    }
    $page->is_home = $is_home;
    $page->banner_content = $data['banner_content'];
    $page->banner = $content;
    $page->update();
    if ($page) {
      return redirect()->route('admin.pages.index')->with(['success' => 'Page updated Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function restore($id)
  {
    $page = Page::withTrashed()->whereId($id)->first();
    if ($page->restore()) {
      return redirect()->back()->with(['success' => 'Page Restored Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function disable($id)
  {
    $page = Page::whereId($id)->first();
    if ($page->delete()) {
      return redirect()->back()->with(['success' => 'Page Deleted Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function destroy($id)
  {
    $page = Page::withTrashed()->whereId($id)->firstOrFail();
    if ($page->forceDelete()) {
      return redirect()->back()->with(['success' => 'Page Deleted Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function storeInnerElement(Request $request)
  {
    $data = $request->except(['_method', '_token']);
    $position = PageElements::max('position') + 1;
    $page_elements = PageElements::create([
      'page_id' => $data['pageId'],
      'element_id' => $data['elementId'],
      'page_section_id' => $data['parentId'],
      'sub_section_id' => $data['sid'],
      'position' => $position,
    ]);
    $element = Element::whereId($request->elementId)->with('child_element')->first();
    if ($element->type == "parent") {
      $child_elements = PageElements::create([
        'page_id' => $page_elements->page_id,
        'element_id' => $page_elements->element->child_element->id,
        'page_section_id' => $page_elements->page_section_id,
        'sub_section_id' => $page_elements->sub_section_id,
        'position' => $page_elements->max('position') + 1,
      ]);

      if ($page_elements->children_ids == null) {
        $children_ids = $child_elements->id . ',';
      } else {
        $children_ids = $page_elements->children_ids . $child_elements->id . ',';
      }
      $page_elements->update([
        'children_ids' => $children_ids
      ]);
      if (isset($child_elements)) {
        foreach ($child_elements->element->fields as $field) {
          PageContent::create([
            'page_element_id' => $child_elements->id,
            'field_id' => $field->id,
            'content' => $field->value
          ]);
        }
      }
    }
    if ($page_elements) {
      foreach ($page_elements->element->fields as $field) {
        PageContent::create([
          'page_element_id' => $page_elements->id,
          'field_id' => $field->id,
          'content' => $field->value
        ]);
      }
      return response()->json(['success' => 'Element Added successfully']);
    } else {
      return response()->json(['error' => 'Something went wrong....!']);
    }
  }

  public function getChildPageElement(Request $request)
  {
    $page_element = PageElements::whereId($request->id)->with('element.child_element')->first();
    if (isset($page_element)) {
      $childrenIds = explode(',', $page_element->children_ids);
      $childrens = PageElements::whereIn('id', $childrenIds)->with('content', 'element')->orderBy('id', 'asc')->get();
      $options = view("backend.pages.get_child_element", compact('childrens', 'page_element'))->render();
      return response()->json(['success' => $options]);
    } else {
      return response()->json(['error' => 'something wrong']);
    }
  }

  public function storeChildPe(Request $request)
  {
    $page_element = PageElements::whereId($request->pageEid)->with('element.child_element')->first();
    $child_elements = PageElements::create([
      'page_id' => $page_element->page_id,
      'element_id' => $page_element->element->child_element->id,
      'page_section_id' => $page_element->page_section_id,
      'sub_section_id' => $page_element->sub_section_id,
      'position' => $page_element->max('position') + 1,
    ]);
    if ($page_element->children_ids == null) {
      $children_ids = $child_elements->id . ',';
    } else {
      $children_ids = $page_element->children_ids . $child_elements->id . ',';
    }
    $page_element->update([
      'children_ids' => $children_ids
    ]);

    if (isset($child_elements)) {
      foreach ($child_elements->element->fields as $field) {
        PageContent::create([
          'page_element_id' => $child_elements->id,
          'field_id' => $field->id,
          'content' => $field->value
        ]);
      }
      return response()->json(['success' => 'Element Added Successfully']);
    } else {
      return response()->json(['error' => 'something wrong']);
    }
  }

  public function updateInnerElement(Request $request)
  {
    $pE = PageElements::whereId($request->elementId)->with('content')->first();
    $pE->update([
      'e_id' => $request->id,
      'e_class' => $request->class
    ]);
    $data = $request->except(['_method', '_token', 'elementId', 'class', 'id']);
    if ($data == null) {
      dd($pE);
    } else {
      foreach ($data as $k => $v) {
        $check = explode('_', $k);
        $fieldId = $check['1'];
        if ($request->hasFile($k) != null) {
          $extension = $request->file($k)->extension();
          $image = sprintf('banner_%s' . '.' . $extension, random_int(1, 1000));
          $path = $request->file($k)->storeAs('/images/banner', $image, 'public');
          $imagePath = '/public/storage/' . $path;
          $content = $imagePath;
        } else {
          $content = $v;
        }
        $PageContent = PageContent::where('id', $check['1'])->update(['content' => $content]);
      }
    }
    if ($PageContent) {
      return response()->json(['success' => 'Element Updated successfully']);
    } else {
      return response()->json(['error' => 'something wrong']);
    }
  }

  public function sectionOrder(Request $request)
  {
    foreach ($request->orders as $order) {
      $id = $order[0];
      $newOrder = $order[1];
      $pageSection = PageSection::where('id', $order[0])->update(['order' => $order[1]]);
    }
    return response()->json(['success' => 'Order Updated Successfully']);
  }

  public function getElement(Request $request)
  {
    $data['type'] = $request->type;
    $data['printId'] = $request->parentId;
    $data['sid'] = $request->sid;
    $sections = PageElementSection::orderBy('id', 'asc')->get();
    $elements = Element::where('type', '!=', 'daughter')->orWhereNull('type')->with('fields.content')->get();
    if (isset($sections)) {
      $options = view("backend.pages.get_element", compact('sections', 'elements', 'data'))->render();
      return response()->json(['success' => $options]);
    } else {
      return response()->json(['error' => 'Something went wrong....!']);
    }
  }

  public function getPageSections(Request $request)
  {
    $data = $request->except(['_method', '_token']);
    $pageSections = PageSection::where('page_id', $data['pageId'])->where('parent_id', 0)->orderBy('order', 'asc')->with('section.PageSubSections', 'subsection.PageElements', 'PageElements')->get();
    if (isset($pageSections)) {
      $options = view("backend.pages.get_page_sections", compact('pageSections'))->render();
      return response()->json(['success' => $options]);
    }
  }

  public function addSection(Request $request)
  {
    $data = $request->except(['_method', '_token']);
    $order = PageSection::max('order') + 1;
    $pageSection = PageSection::create([
      'page_id' => $data['pageId'],
      'section_id' => $data['id'],
      'parent_id' => $data['parentId'],
      'sub_section_id' => $data['sid'],
      'order' => $order,
    ]);
    if ($pageSection) {
      return response()->json(['success' => 'success']);
    } else {
      return response()->json(['error' => 'Something went wrong....!']);
    }
  }

  public function changeSelector(Request $request)
  {
    $data = $request->except(['_method', '_token']);
    $pageSection = PageSection::where('id', $data['id'])->first();
    $pageSection->e_class = $data['cssClass'];
    $pageSection->e_id = $data['cssId'];
    $pageSection->container_type = $data['width'];
    if ($pageSection->update()) {
      return response()->json(['success' => 'Section Selector Updated successfully']);
    } else {
      return response()->json(['error' => 'Something went wrong....!']);
    }
  }

  public function deleteSection(Request $request)
  {
    $pageSection = PageSection::whereId($request->id)->first();
    if ($pageSection != null) {
      $pageSection->delete();
      return response()->json(['success' => 'Section Deleted successfully']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function editInnerElement($id)
  {
    $pageElements = PageElements::where('id', $id)->with('content.field', 'element.fields')->first();
    $childrenIds = explode(',', $pageElements->children_ids);
    $childrens = PageElements::whereIn('id', $childrenIds)->with('content', 'element')->orderBy('id', 'asc')->get();
    $options = view("backend.pages.edit_elements", compact('pageElements', 'childrens'))->render();
    return $options;
  }

  public function deleteElements(Request $request)
  {
    if ($request->type == "child") {
      $page_element = PageElements::whereId($request->prentId)->first();
      $children_ids = explode(',', $page_element->children_ids);
      $index = array_search($request->id, $children_ids);
      if ($index !== false) {
        unset($children_ids[$index]);
      }
      $children_ids = implode(',', $children_ids);
      $page_element->update([
        'children_ids' => $children_ids
      ]);
    }
    $elements = PageElements::whereId($request->id)->first();
    if ($elements->delete()) {
      return response()->json(['success' => 'Element Deleted successfully']);
    } else {
      return response()->json(['error' => 'Something went wrong....!']);
    }
  }

}
