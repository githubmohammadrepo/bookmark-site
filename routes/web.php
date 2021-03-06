<?php

use Illuminate\Support\Facades\Schema;

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

Route::get('/', 'LinkController@show');

//myself coding

Route::get('insert','TestController@index');
Route::get('builder','TestController@builder');
Route::get('builder','TestController@select');
Route::get('join','TestController@join');
Route::get('advance','TestController@advance');
Route::get('subquery','TestController@subquery');

//working on migrations
Route::get('/migrate_one',function(){

    $table_name = 'users';
    $column_name='test';
    //condition for table exist
    if (Schema::hasTable($table_name)) {
        echo 'table '.$table_name.' is exist';
    }else{
        echo 'table '.$table_name.' does not exist';
    }

    echo '<br >';
    //condition for column exist
    if (Schema::hasColumn($table_name,$column_name)) {
        echo 'column '.$column_name.' is exist';
    }else{
        echo 'column '.$column_name.' does not exist';
    }

});



//store links
Route::get('insert','LinkController@insert')->name('insert');

//store informations
Route::post('store','LinkController@store')->name('store');

//delete signle post
Route::post('delete','LinkController@delete')->name('delete');

//change or edit link informations
Route::match(array('GET', 'POST'),'change','LinkController@change')->name('change');

//update link informations
Route::post('update','LinkController@update')->name('update');

//show all information in page
Route::get('show','LinkController@show')->name('show');


/**
 *   just for test
*/

Route::get('test',function(){
    return view('store.test.test');
});

//test validation form just show test form
Route::get('testvalidation','TestController@testvalidation');

//test validation form get post data from test form
Route::post('testvalidation','TestController@update')->name('testvalidation');

//end just for test

/**
 * Route custome login
 */
Route::get('login/login','LoginController@login')->name('mylogin');
/**
 * Route custome register
 */
Route::get('register/register','LoginController@register')->name('myregister');


/**
 * Route for show result search
 */
Route::get('search','LinkController@search')->name('search');
Route::post('search','LinkController@search')->name('search-post');


/**
 * authentication laravel Routes
 */
Auth::routes();

Route::get('show', 'LinkController@show')->name('home');
