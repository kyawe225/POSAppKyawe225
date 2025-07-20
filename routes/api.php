<?php

use App\Http\Controllers\Api\CuponController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\UserController;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::group(["prefix" => "/auth", "as" => "auth."], function ($request) {
    $request
        ->post("register", [UserController::class, "register"])
        ->name("register");
});

// Route::group(["prefix" => "/payment_method", "as" => "pm."], function ($request) {
//     $request
//         ->get("register", [UserController::class, "register"])
//         ->name("register");
// });
Route::group(["prefix" => "/supplier", "as" => "sp."], function ($request) {
    $request
        ->get("all", [SupplierController::class, "index"])
        ->name("all");
    $request
        ->get("detail/{id}", [SupplierController::class, "getDetail"])
        ->name("detial");
    $request
        ->put("{id}", [SupplierController::class, "update"])
        ->name("detial");
    $request
        ->post("", [SupplierController::class, "insert"])
        ->name("create");
    $request
        ->delete("delete/{id}", [SupplierController::class, "delete"])
        ->name("delete");
});

Route::group(["prefix" => "/product-category", "as" => "pc."], function ($request) {
    $request
        ->get("all", [ProductCategoryController::class, "index"])
        ->name("all");
    $request
        ->get("detail/{id}", [ProductCategoryController::class, "getDetail"])
        ->name("detial");
    $request
        ->put("{id}", [ProductCategoryController::class, "update"])
        ->name("detial");
    $request
        ->post("create", [ProductCategoryController::class, "insert"])
        ->name("create");
    $request
        ->delete("delete/{id}", [ProductCategoryController::class, "delete"])
        ->name("delete");
});


Route::group(["prefix" => "/cupon", "as" => "cu."], function ($request) {
    $request
        ->get("all", [CuponController::class, "index"])
        ->name("all");
    $request
        ->get("detail/{id}", [CuponController::class, "getDetail"])
        ->name("detial");
    $request
        ->put("{id}", [CuponController::class, "update"])
        ->name("detial");
    $request
        ->post("create", [CuponController::class, "insert"])
        ->name("create");
    $request
        ->delete("delete/{id}", [CuponController::class, "delete"])
        ->name("delete");
});

