<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

  protected function authenticated(Request $request, $user)
  {
    Flashy::success("User Login Successful.");
    return redirect()->route('user.dashboard');
  }

   public function showLoginForm()
   {
     if (Auth::check()) {
       return redirect()->route('user.dashboard');
     } else {
       return view('frontend.user.login');
     }
   }
}
