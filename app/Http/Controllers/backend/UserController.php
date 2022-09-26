<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helpers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  public function index(Request $request)
  {
    $users = User::paginate(12);
    return view('backend.users.index', compact('users'));
  }

  public function show($id)
  {
    $user = User::withTrashed()->whereSlug($id)->first();
    // dd($user);
    return view('backend.users.show', compact('user'));
  }

  public function create()
  {
    return view('backend.users.create');
  }
  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'billing_coordinates' => 'required',
        'phone' => 'unique:users',
      ]);
      if ($validator->fails()) {
        $error = $validator->errors()->first();
        return redirect()->back()->with('error', $error);
      } else {
        $data = $request->except(['_method', '_token']);
        if (isset($data['same_as_billing_address']) && $data['same_as_billing_address'] == 'on') {
          $data["delivery_address1"] = $data["billing_address1"];
          $data["delivery_address2"] = $data["billing_address2"];
          $data["delivery_city"] = $data["billing_city"];
          $data["delivery_state"] = $data["billing_state"];
          $data["delivery_zip"] = $data["billing_zip"];
          $data["delivery_coordinates"] = $data["billing_coordinates"];
        }
        if (isset($data['same_as_customer']) && $data['same_as_customer'] == 'on') {
          $data["recipient_name"] = $data["first_name"] . " " . $data["last_name"];
          $data["recipient_phone"] = $data["phone"];
        }
        $user = new User();
        $fillable = $user->getFillable();
        foreach ($fillable as $columnName) {
          if (isset($data[$columnName]) && $data[$columnName]) {
            if ($data[$columnName] != $user[$columnName]) {
              $user[$columnName] = $data[$columnName];
            }
          }
        }
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User Created Successfully.');
      }
    } catch (\Exception $e) {

      $error = $e->getMessage();

      return redirect()->back()->with('error', $error);
    }
  }

  public function getFinalStatusAttribute()
  {
    if ($this->attributes['deactivated'] === 1) {
      $this->finalStatus = "DEACTIVATED";
    } else {
      $this->finalStatus = "ACTIVE";
    }
    return $this->finalStatus;
  }

  public function destroy($id)
  {
    $user = User::whereId($id)->first();
    if ($user->delete()) {
      return redirect()->back()->with(['success' => 'User Deleted Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }

  public function restore($id)
  {
    $user = User::withTrashed()->whereId($id)->first();
    if ($user->restore()) {
      return redirect()->back()->with(['success' => 'User Restored Successfully..!']);
    } else {
      return redirect()->back()->with(['error' => 'Something went wrong....!']);
    }
  }
}
