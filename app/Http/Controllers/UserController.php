<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request)
    {
      try {
        $user = User::where('email', $request->input('email'))->first();
        if($user){
          if(Hash::check($request->input('password'), $user->password)){
            $token = JWTAuth::fromUser($user);
            return Array('token'=>$token, 'user'=>$user);
          }
        }
        return response()->json(['error' => 'invalid_credentials'], 401);
     } catch (JWTException $e) {
         // something went wrong whilst attempting to encode the token
         return response()->json(['error' => 'could_not_create_token'], 500);
     }
    }

    public function logout()
    {
      return JWTAuth::setToken(JWTAuth::getToken())->invalidate();
    }

    public function token()
    {
      return JWTAuth::toUser(JWTAuth::getToken());
    }
}
