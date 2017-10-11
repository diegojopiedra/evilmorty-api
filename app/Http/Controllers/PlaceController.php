<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Place;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sessionUser = JWTAuth::toUser(JWTAuth::getToken());
        $showUser = null;
        if($sessionUser && $sessionUser->superUser && $request->input('userId')){
          $showUser = User::find($request->input('userId'));
        }else{
          $showUser = $sessionUser;
        }

        if($showUser){
          return $showUser->places;
        }else{
          return response()->json(['error' => 'user_not_found'], 401);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $sessionUser = JWTAuth::toUser(JWTAuth::getToken());
      $showUser = null;
      if($sessionUser && $sessionUser->superUser && $request->input('userId')){
        $showUser = User::find($request->input('userId'));
      }else{
        $showUser = $sessionUser;
      }

      if($showUser){
        $place =  new Place();
        $place->name = $request->input('name');
        $place->lat = $request->input('lat');
        $place->lon = $request->input('lon');
        $place->description = $request->input('description');
        $showUser->places()->save($place);
      }else{
        return response()->json(['error' => 'user_not_found'], 401);
      }
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
}
