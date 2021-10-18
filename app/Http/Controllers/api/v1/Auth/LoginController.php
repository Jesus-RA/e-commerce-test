<?php

namespace App\Http\Controllers\api\v1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if( !Auth::attempt( $credentials, true ) ){
            return response()->json([
                'error' => [
                    'message' => 'Credentials no match our records.'
                ]
            ], 403);
        }

        $request->session()->regenerate();
        return response()->json([
            'data' => new UserResource( Auth::user() )
        ], 200);

    }
}
