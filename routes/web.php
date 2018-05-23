<?php
Route::get('api/customer','CustomerController@index');
Route::get('/', function () {
    return view('welcome');
});
