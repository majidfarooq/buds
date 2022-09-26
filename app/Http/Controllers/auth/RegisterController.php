<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm($var = null)
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        } else {
            return view('frontend.user.register', compact('var'));
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => 'required|unique:users',
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()) {
            Flashy::error("Please Enter Correct Information!.");
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::create([
                'role_id' => $request->role_id ?? 1,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $this->guard()->login($user);
            Flashy::success("Your Account Created Successfully.");
            return redirect()->route('user.dashboard');
        }
    }
}
