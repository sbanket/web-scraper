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

Route::get('/', 'RunController@runList')->name('run.list');
Route::get('/sync-data/{runId}', 'RunController@syncData')->name('run.sync.data');

Route::get('/show-run-data/{runId}', 'DataController@showData')->name('run.show.data');
