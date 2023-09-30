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

Route::prefix("/auth")->group(function(){

        Route::post("/login", [App\Http\Controllers\Auth\AuthController::class, "login"])->name("login");

        Route::post("/logout", [App\Http\Controllers\Auth\AuthController::class, "logout"])->name("logout");

        Route::post("/refresh", [App\Http\Controllers\Auth\AuthController::class, "refresh"])->name("refresh");

        //reg Client

        Route::post("/register-client", [App\Http\Controllers\Auth\AuthController::class, "registerClient"])->name("register-client");


});


Route::prefix("/public")->group(function () {


    /*==================
    *GET ROUTES
     */
    Route::get("/conseils", [App\Http\Controllers\Api\ConseilController::class, "getAll"])->name("conseils");

    Route::get("/conseils/{id}", [App\Http\Controllers\Api\ConseilController::class, "get"])->name("conseils.show");

    Route::get("/typeconseils", [App\Http\Controllers\Api\TypeConseilController::class, "getAll"])->name("type-conseils");

    Route::get("/typeconseils/{id}", [App\Http\Controllers\Api\TypeConseilController::class, "get"])->name("type-conseils.get");
});


Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix("/admin")->group(function () {

        /*==================
    *POST ROUTES
     */
        Route::post("/conseils", [App\Http\Controllers\Api\ConseilController::class, "add"])->name("conseils.add");

        Route::post("/type-conseils", [App\Http\Controllers\Api\TypeConseilController::class, "add"])->name("type-conseils.add");


        /*==================

    *PUT ROUTES
     */

        Route::put("/conseils/{id}", [App\Http\Controllers\Api\ConseilController::class, "update"])->name("conseils.update");

        Route::put("/type-conseils/{id}", [App\Http\Controllers\Api\TypeConseilController::class, "update"])->name("type-conseils.update");


        /*==================

    *DELETE ROUTES
     */


        Route::delete("/conseils/{id}", [App\Http\Controllers\Api\ConseilController::class, "delete"])->name("conseils.delete");

        Route::delete("/type-conseils/{id}", [App\Http\Controllers\Api\TypeConseilController::class, "delete"])->name("type-conseils.delete");
    });
});
