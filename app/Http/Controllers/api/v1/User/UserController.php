<?php

namespace App\Http\Controllers\api\v1\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = new UserCollection( User::all() );
        return response()->json( $users, 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if( User::emailExists( $request->email )->first() ){
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

        return response()->json( [
            'data' => new UserResource( $user )
        ], 201 );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Int $userId)
    {
        $user = User::find( $userId );

        if( !$user ){
            return response()->json([
                'error' => [
                    'message' => "User with id $userId not found."
                ]
            ], 404);
        }

        return response()->json( [
            'data' => new UserResource( $user )
        ], 200 );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update( $request->all() );

        return response()->json([
            'data' => new UserResource( $user )
        ], 201 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([], 204);
    }
}
