<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', 'APIController@register');
Route::post('/login', 'APIController@login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //Checklist
    Route::get('/checklist', 'APIController@getChecklist');
    Route::post('/checklist', 'APIController@addChecklist');
    Route::delete('/checklist/{id}', 'APIController@deleteChecklist');

    //ChecklistItem
    Route::get('/checklist/{id}/item', 'APIController@getAllChecklistItem');
    Route::post('/checklist/{id}/item', 'APIController@addChecklistItem');
    Route::get('/checklist/{checklistId}/item/{checklistItemId}', 'APIController@getChecklistItem');
    Route::put('/checklist/{checklistId}/item/{checklistItemId}', 'APIController@updateChecklistItem');
    Route::delete('/checklist/{checklistId}/item/{checklistItemId}', 'APIController@deleteChecklistItem');
    Route::put('/checklist/{checklistId}/item/rename/{checklistItemId}', 'APIController@renameChecklistItem');


});