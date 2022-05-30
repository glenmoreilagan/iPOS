<?php

namespace App\Http\Middleware;

// use Illuminate\Support\Str;

use Closure;
use Response;
use Session;

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

      if(!Session::has('userinfo')) {
        // $random = Str::random(50);
        return redirect("/login?err='nosession'");
      }
      
      $response = $next($request);

      return $response
        ->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
        ->header('Pragma','no-cache')
        ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
      
      // if (!isset($_SERVER["HTTP_GLEN_KEY"])) {
      //   return Response::json(['status'=>'invalid', 'msg'=>'Invalid credentials']);
      // } else {
      //   if ($_SERVER['HTTP_GLEN_KEY'] == md5(123)) { // 202cb962ac59075b964b07152d234b70
      //     return $next($request);
      //   } else {
      //     return Response::json(['status'=>'invalid', 'msg'=>'Invalid credentials']);
      //   }
      // }
      // return $next($request);
    }
}
