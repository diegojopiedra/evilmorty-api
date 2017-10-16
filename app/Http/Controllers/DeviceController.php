<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Place;
use App\Device;
use App\Log;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $sessionUser = JWTAuth::toUser(JWTAuth::getToken());
      $queryUser = null;
      if($sessionUser && $sessionUser->superUser && $request->input('userId')){
        $queryUser = User::find($request->input('userId'));
      }else{
        $queryUser = $sessionUser;
      }

      if($queryUser){
        $place = $queryUser->places->find($request->input('placeId'));
        if($place){
          return $place->devices;
        }else{
          response()->json(['error' => 'place_not_found'], 401);
        }
      }else{
        return response()->json(['error' => 'user_not_found'], 401);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Request  $request->input('token')
     * @param  \Illuminate\Http\Request  $request->input('')
     * @param  \Illuminate\Http\Request  $request->input()
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $sessionUser = JWTAuth::toUser(JWTAuth::getToken());
      $queryUser = null;
      if($sessionUser && $sessionUser->superUser && $request->input('userId')){
        $queryUser = User::find($request->input('userId'));
      }else{
        $queryUser = $sessionUser;
      }

      if($queryUser){
        $place = $queryUser->places->find($request->input('placeId'));
        if($place){
          $device =  new Device();
          $device->name = $request->input('name');
          $device->secretKey = $this->RandomString(25);
          $device->mutantKey = $this->RandomString(10);
          $place->devices()->save($device);
          return array(
            '_id' => $device->id,
            'name' => $device->name,
            'secretKey' => $device->secretKey,
            'mutantKey' => $device->mutantKey
          );
        }else{
          return response()->json(['error' => 'place_not_found'], 401);
        }
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
    public function show($id, Request $request)
    {
      $sessionUser = JWTAuth::toUser(JWTAuth::getToken());
      $queryUser = null;
      if($sessionUser && $sessionUser->superUser && $request->input('userId')){
        $queryUser = User::find($request->input('userId'));
      }else{
        $queryUser = $sessionUser;
      }

      if($queryUser){
        return Device::find($id);
      }else{
        return response()->json(['error' => 'user_not_found'], 401);
      }
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

    public function service($deviceId, $data, $mutantKey)
    {
      $error = response()->json(['error' => 'resource_not_found'], 404);
      $device = Device::find($deviceId);
      if(is_null($device)){
        return $error;
      }else{
        if($device->mutantKey == $mutantKey){
          $device->mutantKey = $this->RandomString(45);
          $device->save();
          $log = new Log();
          foreach (json_decode($data) as $name => $value) {
            $log->$name = $value;
          }
          $device->log()->save($log);
          return response()->json(['success' => 'true', 'mutantKey' => $device->mutantKey, 'log' => $log]);
        }else{
          return $error;
        }
      }
    }

    private function RandomString($length = 10)
    {
        $characters = '0123456789abc.-defghijklmnop!qrstuvwxyzA_.BCDEFGHIJKLMNOPQRSTUVWXYZ.-_';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }
}
