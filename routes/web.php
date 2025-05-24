<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderNowController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('/dashboard');
// });


Route::group(['middleware'=>'guest'],function(){
    Route::get('/login',[LoginController::class,'index'])->name('user.login');
    Route::post('/authenticate',[LoginController::class,'authenticate'])->name('user.authenticate');
    Route::post('/process-register',[LoginController::class,'processRegister'])->name('user.processRegister');
    Route::get('/register',[LoginController::class,'register'])->name('user.register');


});
Route::group(['middleware'=>'auth'],function(){
    Route::get('/logout',[LoginController::class,'logout'])->name('user.logout');
    Route::get('/',[LoginController::class,'dashboard'])->name('user.dashboard');

});

Route::get('/blank',[LoginController::class,'blank'])->name('user.blank');


Route::get('/charge',[LoginController::class,'charge'])->name('user.charge');

Route::get('/howtowork',[LoginController::class,'howtowork'])->name('user.howtowork');

Route::get('/orderlist',[LoginController::class,'orderlist'])->name('user.orderlist');


Route::get('/payment',[LoginController::class,'payment'])->name('user.payment');

Route::get('/reportsview',[LoginController::class,'reportsview'])->name('user.reportsview');
Route::get('/product',[LoginController::class,'product'])->name('user.product');



Route::get('/track',[LoginController::class,'track'])->name('user.track');

//----------------Report------------
Route::get('/reportsview', [ReportController::class, 'viewReport'])->name('user.reportsview');
Route::get('/report',[ReportController::class,'index'])->name('user.report');
Route::get('/report', [ReportController::class, 'reportPage'])->name('user.report');
Route::Post('/report/authenticate',[ReportController::class,'authenticate'])->name('report.authenticate');



//------------about us-------------------------
Route::get('/about',[AboutUsController::class,'index'])->name('user.about');
Route::get('/about',[AboutUsController::class,'aboutus'])->name('user.about');



//-----------------order now------------------------
Route::get('/ordernow',[OrderNowController::class,'ordernow'])->name('user.ordernow');
Route::get('/ordernow',[OrderNowController::class,'ordernowlist'])->name('user.ordernow');
Route::get('/productview',[OrderNowController::class,'productview'])->name('user.productview');




