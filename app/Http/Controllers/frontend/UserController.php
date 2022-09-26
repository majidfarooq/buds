<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function dashboard()
  {
    return view('frontend.user.dashboard.index');
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
       'name' => ['required', 'string', 'max:255'],
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    } else {
      $user = User::whereId(Auth::user()->id)->first();
      if ($request->hasFile('image') != null) {
        $extension = $request->file('image')->extension();
        $image = sprintf('user_%s' . '.' . $extension, random_int(1, 1000));
        $path = $request->file('image')->storeAs('/images/user', $image, 'public');
        $image = '/public/storage/' . $path;
      } else {
        $image = $user->image;
      }
      $user->update([
         'name' => $request->name,
         'email' => isset($request->email) ? $request->email : $user->email,
      ]);
      Flashy::success('Profile Updated Successfully');
      return redirect()->route('user.dashboard');
    }
  }

  public function password(Request $request)
  {
    $data = [];
    $data['request'] = $request->All();
    $validator = Validator::make($request->all(), [
       'current_password' => [
          'required', function ($attribute, $value, $fail) {
            if (!Hash::check($value, Auth::user()->password)) {
              $fail('Current Password didn\'t match');
            }
          },
       ],
       'password' => [
          'required',
          'string',
          'min:8',
          'max:30',
          'confirmed',
          'different:current_password',
       ],
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput(['tab' => 'passwordTab']);
    } else {
      $user = auth()->user();
      $user->update([
         'password' => Hash::make($data['request']['password'])
      ]);
      Auth::logout();
      Flashy::success('Password Has Changed Please Login with new Password');
      return redirect()->route('login');
    }
//        return view('frontend.user.profile.index');
  }

  public function resetPassword(Request $request)
  {
    $data = [];
    $data['request'] = $request->All();

    $validator = Validator::make($request->all(), [
       'current_password' => [
          'required', function ($attribute, $value, $fail) {
            if (!Hash::check($value, Auth::user()->password)) {
              $fail('Current Password didn\'t match');
            }
          },
       ],
       'password' => [
          'required',
          'string',
          'min:8',
          'max:30',
          'confirmed',
          'different:current_password',
          'regex:/[a-z]/',      // must contain at least one lowercase letter
          'regex:/[A-Z]/',      // must contain at least one uppercase letter
          'regex:/[0-9]/',      // must contain at least one digit
          'regex:/[@$!%*#?&]/', // must contain a special character
       ],
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    } else {
      $user = auth()->user();
      $user->update([
         'password' => Hash::make($data['request']['password'])
      ]);
      Auth::logout();
      Flashy::success('Your Password Has been Changed Please Login with new Password');
      return redirect()->route('home');
    }
  }
}
