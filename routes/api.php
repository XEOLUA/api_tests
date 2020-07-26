<?php

use App\Services\ShowTests;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('tests', 'TestController');

Route::middleware(['au'])->group(function () {

    Route::post('admin/create', 'HomeController@createtest');

    Route::get('admin/list', ['middleware' => 'au', function(){
        $t = new App\Services\ShowTests();
        return $t->list();
    }]);

    Route::get('admin/showtest/{id}', ['middleware' => 'au', function(){
        $t = new App\Services\ShowTests();
        return $t->showtest(1);
    }]);
});

Route::get('error', 'HomeController@error')->name('error');
Route::post('test', 'HomeController@testrun')->name('testrun');
Route::get('showtest/{test_identifier}', 'HomeController@showtest')->name('showtest');
