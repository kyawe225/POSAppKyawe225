<?php

use App\Http\Controllers\SampleController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/a", [SampleController::class, "hello"]);
