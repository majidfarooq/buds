<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Element;
use App\Models\ElementFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ElementController extends Controller
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
        2 => 'type',
        4 => 'created_at',
        5 => 'id',
      );
      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');
      $totalData = Element::when($search != '', function ($query) use ($search) {
        $query->where('title', 'LIKE', "%{$search}%");
      })->count();
      $elements = Element::when($search != '', function ($query) use ($search) {
        $query->where('title', 'LIKE', "%{$search}%");
      })->offset($start)->limit($limit)->orderBy($order, $dir)->get();
      $totalFiltered = $totalData;
      $data = array();
      if (!empty($elements)) {
        foreach ($elements as $element) {
          $edit = route('admin.element.edit', $element->id);
          $delete = route('admin.elementDelete');
          $csrf = csrf_token();
          $nestedData['id'] = $element->id;
          $nestedData['title'] = $element->title;
          $nestedData['type'] = $element->type;
          $nestedData['created_at'] = date('j M Y h:i a', strtotime($element->created_at));
          $nestedData['action'] = "<form action='{$delete}' method='POST'>
                                                                                            <input type='hidden' name='elementId' value='$element->id' />
                                                                                            <input type='hidden' value='{$csrf}' name='_token'>
                                                                                            <button type='submit' data-title='Delete' class='btn btn-danger btn-circle'>
                                                                                            <i class='fas fa-trash-alt'></i>
                                                                                            </button>
                                                                                            </form>";
          $nestedData['action'] .= "<a class='btn btn-info btn-circle' href='{$edit}'><i class='fas fa-edit'></i></a>";
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
      return view('backend.elements.index');
    }
  }

  public function create(Request $request)
  {
    $type = DB::select(DB::raw("SHOW COLUMNS FROM element_fields WHERE Field = 'type'"))[0]->Type;
    preg_match_all("/'([^']+)'/", $type, $matches);
    $fields = $matches[1];
    $parents = Element::where('type', 'parent')->doesntHave('child_element')->get();
    if ($fields) {
      return view('backend.elements.create', compact('fields', 'parents'));
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'title' => 'required',
      'template' => 'required',
    ]);
    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    } else {
      if ($request->type == "daughter") {
        $parentId = $request->parentId;
      } else {
        $parentId = null;
      }
      $element = new Element();
      $element->title = $request->title;
      $element->type = $request->type;
      $element->parentId = $parentId;
      $element->template = $request->template;
      if ($element->save()) {
        return redirect()->route('admin.elements.index')->with(['success' => 'Element Created Successfully..!']);
      } else {
        return redirect()->back()->with(['error' => 'Something went wrong....!']);
      }
    }
  }

  public function edit(Element $element)
  {
    $type = DB::select(DB::raw("SHOW COLUMNS FROM element_fields WHERE Field = 'type'"))[0]->Type;
    preg_match_all("/'([^']+)'/", $type, $matches);
    $fields = $matches[1];
    $element->load('parent_element', 'fields');
    $parents = Element::where('type', 'parent')->where('id', '!=', $element->id)->doesntHave('child_element')->get();
    return view('backend.elements.edit', compact('element', 'parents', 'fields'));
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'title' => 'required',
      'template' => 'required',
    ]);
    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    } else {
      if ($request->type == "parent") {
        $parentId = null;
      } else {
        $parentId = $request->parentId;
      }

      $element = Element::whereId($request->elementId)->first();
      $element->title = $request->title;
      $element->type = $request->type;
      $element->parentId = $parentId;
      $element->template = $request->template;
      if ($element->save()) {
        return redirect()->route('admin.elements.index')->with(['success' => 'Element Created Successfully..!']);
      } else {
        return redirect()->back()->with(['error' => 'Something went wrong....!']);
      }
    }
  }

  public function delete(Request $request)
  {
    $element = Element::whereId($request->elementId)->first();
    if ($element->delete()) {
      return redirect()->back()->with(['success' => 'ELement Deleted Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function fieldCreate(Request $request)
  {
    if ($request->field_type == "attachment") {
      if ($request->hasFile('field_value') != null) {
        $extension = $request->file('field_value')->extension();
        $image = sprintf('field_%s' . '.' . $extension, random_int(1, 1000));
        $path = $request->file('field_value')->storeAs('/field', $image, 'public');
        $content = '/public/storage/' . $path;
      } else {
        $content = $request->field_value;
      }
    } else {
      $content = $request->field_value;
    }
    $field = new ElementFields();
    $field->title = $request->field_title;
    $field->type = $request->field_type;
    $field->value = $content;
    $field->element_id = $request->element_id;
    if ($field->save()) {
      return response()->json(['success' => 'Field Added Successfully']);
    } else {
      return response()->json(['error' => 'Something went wrong']);
    }
  }

  public function fieldGet(Request $request)
  {
    $type = DB::select(DB::raw("SHOW COLUMNS FROM element_fields WHERE Field = 'type'"))[0]->Type;
    preg_match_all("/'([^']+)'/", $type, $matches);
    $fields_type = $matches[1];
    $element = Element::whereId($request->elementId)->with('fields')->first();
    if (isset($element)) {
      $options = view("backend.elements.get_fields", compact('element', 'fields_type'))->render();
      return response()->json(['success' => $options]);
    } else {
      return response()->json(['error' => 'something wrong']);
    }
  }

  public function fieldUpdate(Request $request)
  {
    $field = ElementFields::whereId($request->fieldId)->first();
    if ($request->type == "attachment") {
      if ($request->hasFile('value') != null) {
        $extension = $request->file('value')->extension();
        $image = sprintf('field_%s' . '.' . $extension, random_int(1, 1000));
        $path = $request->file('value')->storeAs('/field', $image, 'public');
        $content = '/public/storage/' . $path;
      } else {
        $content = $field->value;
      }
    } else {
      $content = $request->value;
    }
    $field->title = $request->title;
    $field->type = $request->type;
    $field->value = $content;
    if ($field->save()) {
      return response()->json(['success' => 'Field Added Successfully']);
    } else {
      return response()->json(['error' => 'Something went wrong']);
    }
  }

  public function fieldDelete(Request $request)
  {
    $field = ElementFields::whereId($request->id)->first();
    if ($field->delete()) {
      return response()->json(['success' => 'Field Deleted successfully']);
    } else {
      return response()->json(['error' => 'Something went wrong....!']);
    }
  }
}
