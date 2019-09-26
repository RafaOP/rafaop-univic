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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('professores', 'ProfessorController@index');
Route::get('disciplinas', 'DisciplinaController@index');
Route::post('professores', 'ProfessorController@store');
Route::post('disciplinas', 'DisciplinaController@store');
Route::delete('professores', 'ProfessorController@destroy');
Route::delete('disciplinas', 'DisciplinaController@destroy');
Route::patch('professores', 'ProfessorController@update');
Route::patch('disciplinas', 'DisciplinaController@update');
Route::post('professor', 'ProfessorController@getOne');
Route::post('disciplina', 'DisciplinaController@getOne');
// Route::get('disciplinas', 'DisciplinaController@getOne');
// Route::get('professores', 'ProfessorController@getOne');