<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(TwilioController::class)->group(function(){
    Route::get('make-call', 'make_call');
    Route::get('/handle-call','handle_call')->name('handle_call');
    Route::get('/handle-record','handle_record')->name('handle_record');
});
