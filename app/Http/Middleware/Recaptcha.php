<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Http;
class Recaptcha
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->input('type') == 3)
        {
            if($request->input('re-captcha-v3') == '') {
                return back()->withErrors(['captcha' => 'Captcha token missing']); 
            }
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.re-captcha-v3.secret_key'),
                'response' => $request->input('re-captcha-v3'),
                'remoteip' => $request->ip()
            ]);
            $result = $response->json();
            if (!$result['success'])
            {
                return back()->withErrors(['captcha' => 'Captcha Expired !']);
            }

            if($result['score'] < 0.8) {
                return back()->withErrors(['re-captcha-2' => true]) ;
            }

           return back()->withErrors(['re-captcha-2' => true]) ;
        }else if ($request->input('type') == 2) {

        }
    }
}
