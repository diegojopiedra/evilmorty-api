<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use Illuminate\Support\Facades\Hash;


Route::get('/', function () {
    /*$user = new User();
    $user->name = "Diego";
    $user->lastname = "Piedra Araya";
    $user->email = "diegojopiedra@gmail.com";
    $user->password = Hash::make("1234");
    $user->save();*/
    return User::all() . view('welcome');
});
