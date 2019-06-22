<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class TokenController extends Controller
{
    //
    public function requestToken(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $api_token=$user->api_token;
            ///dd('here');
            return redirect()->back()->with('flash_message', $api_token);
        }
        return redirect()->back();
    }
}
