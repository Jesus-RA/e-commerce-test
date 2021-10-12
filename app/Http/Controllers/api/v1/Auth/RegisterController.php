<?php

namespace App\Http\Controllers\api\v1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if( User::where('email', $request->email)->first() ){
            return response()->json([
                'error' => [
                    'message' => 'Email has already registered.'
                ]
            ], 409);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make( $request->password )
        ]);
        Auth::login( $user );

        return response()->json( $user, 201 );
    }
}
