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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();
Route::get('escalations/create/{task_id}', [
    'as' => 'escalations.create',
    'uses' => 'EscalationController@create'
]);
Route::resource('tasks', 'TaskController');
Route::resource('tags', 'TagController')->only(['index', 'store', 'destroy']);
Route::resource('backups', 'BackupController')->except('create', 'show');
Route::resource('escalations', 'EscalationController')->except('create', 'show');
