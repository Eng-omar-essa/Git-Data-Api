<?php

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
// Route::get('github/finder/{name}', ['uses' => 'GitHub\GitHubController@get_files', 'as' => 'github.get_files']);
Route::get('gitlab/finder/{id}', ['uses' => 'GitLab\GitController@get_files', 'as' => 'gitlab.get_files']);
Route::get('github/finder/{name}', ['uses' => 'GitHub\GitHubController@getFiles', 'as' => 'github.getFiles']);
Route::resource('github','GitHub\GitHubController',['only'=> ['index', 'getFiles']]);
Route::resource('bitbucket','BitBucket\BitBucketController',['only'=> ['index', 'get_files']]);
Route::resource('gitlab','GitLab\GitController',['only'=> ['index', 'show']]);




