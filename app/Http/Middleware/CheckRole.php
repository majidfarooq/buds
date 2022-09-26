<?php

namespace App\Http\Middleware;

//use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next, string $role)
  {
    $roles = [
      'user' => [1],
//          'vendor' => [2]
    ];
    $roleIds = $roles[$role] ?? [];
    if (!in_array(auth::user()->role_id, $roleIds)) {
      abort(401);
//    return response()->view('errors.unauthorized');
    }
    return $next($request);
  }
}
