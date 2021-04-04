<?php

use App\Http\Controllers\API\ContactsController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function(){
    Route::get('/user', [ UsersController::class, 'show' ]);

    // Contacts
    Route::get('/contacts', [ ContactsController::class, 'index' ] );
    Route::get('/user-contacts', [ ContactsController::class, 'getUserContacts' ] );
    Route::put('/contacts/{contact}/bookmark', [ ContactsController::class, 'bookmark' ]);

});

