<?php

use App\Http\Controllers\SimpleStoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix("/")->group(function () {

    Route::get("", [SimpleStoreController::class, "index"])->name("index");

    Route::get("/add-type-conseil", [SimpleStoreController::class, "formTypeConseil"])->name("add-type-conseil");


    Route::get("/add-conseil", [SimpleStoreController::class, "formConseil"])->name("add-conseil");


    Route::post("/store-type-conseil", [SimpleStoreController::class, "storeTypeConseil"])->name("store-type-conseil");



    Route::post("/store-conseil", [SimpleStoreController::class, "storeConseil"])->name("store-conseil");



    Route::delete("/delete-type-conseil/{id}", [SimpleStoreController::class, "deleteTypeConseil"])->name("delete-type-conseil");


    Route::delete("/delete-conseil/{id}", [SimpleStoreController::class, "deleteConseil"])->name("delete-conseil");


});
