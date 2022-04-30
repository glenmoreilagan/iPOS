<?php

namespace App\Http\Middleware;

use Closure;
use Response;

class SampleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      // if (!isset($_SERVER["HTTP_GLEN_KEY"])) {
      //   return Response::json(['status'=>'invalid', 'msg'=>'Invalid credentials']);
      // } else {
      //   if ($_SERVER['HTTP_GLEN_KEY'] == md5(123)) { // 202cb962ac59075b964b07152d234b70
      //     return $next($request);
      //   } else {
      //     return Response::json(['status'=>'invalid', 'msg'=>'Invalid credentials']);
      //   }
      // }
      return $next($request);
    }
}
