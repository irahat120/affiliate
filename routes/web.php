<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>'guest'],function(){
    Route::get('/login',[LoginController::class,'index'])->name('user.login');
    Route::post('/authenticate',[LoginController::class,'authenticate'])->name('user.authenticate');
    Route::post('/process-register',[LoginController::class,'processRegister'])->name('user.processRegister');
    Route::get('/register',[LoginController::class,'register'])->name('user.register');


});
Route::group(['middleware'=>'auth'],function(){
    Route::get('/logout',[LoginController::class,'logout'])->name('user.logout');
    Route::get('/dashboard',[LoginController::class,'dashboard'])->name('user.dashboard');

});




