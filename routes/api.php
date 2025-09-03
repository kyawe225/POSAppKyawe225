<?php

use App\Http\Controllers\Api\CuponController;
use App\Http\Controllers\Api\InventoryOrderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
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

    $request->post("login", [UserController::class, "login"])->name("login");
});

// Route::group(["prefix" => "/payment_method", "as" => "pm."], function ($request) {
//     $request
//         ->get("register", [UserController::class, "register"])
//         ->name("register");
// });
Route::group(["prefix" => "/supplier", "as" => "sp."], function ($request) {
    $request->get("all", [SupplierController::class, "index"])->name("all");
    $request
        ->get("detail/{id}", [SupplierController::class, "getDetail"])
        ->name("detial");
    $request->put("{id}", [SupplierController::class, "update"])->name("edit");
    $request->post("", [SupplierController::class, "insert"])->name("create");
    $request
        ->delete("delete/{id}", [SupplierController::class, "delete"])
        ->name("delete");
});

Route::group(["prefix" => "/product-category", "as" => "pc."], function (
    $request,
) {
    $request
        ->get("all", [ProductCategoryController::class, "index"])
        ->name("all");
    $request
        ->get("detail/{id}", [ProductCategoryController::class, "getDetail"])
        ->name("detial");
    $request
        ->put("{id}", [ProductCategoryController::class, "update"])
        ->name("edit");
    $request
        ->post("", [ProductCategoryController::class, "insert"])
        ->name("create");
    $request
        ->delete("delete/{id}", [ProductCategoryController::class, "delete"])
        ->name("delete");
});

Route::group(
    ["prefix" => "/cupon", "as" => "cu.", "middleware" => "auth:sanctum"],
    function ($request) {
        $request->get("all", [CuponController::class, "index"])->name("all");
        $request
            ->get("detail/{id}", [CuponController::class, "getDetail"])
            ->name("detial");
        $request->put("{id}", [CuponController::class, "update"])->name("edit");
        $request->post("", [CuponController::class, "insert"])->name("create");
        $request
            ->delete("delete/{id}", [CuponController::class, "delete"])
            ->name("delete");
        $request
            ->post("check", [CuponController::class, "check"])
            ->name("delete");
    },
);

Route::group(["prefix" => "/product", "as" => "p."], function ($request) {
    $request->get("all", [ProductController::class, "index"])->name("all");
    $request
        ->get("category/{id}", [ProductController::class, "getByCategory"])
        ->name("filter_category");
    $request
        ->get("category/paginate/{id}", [
            ProductController::class,
            "getByCategoryPagination",
        ])
        ->name("filter_category_paginate");
    $request
        ->get("detail/{id}", [ProductController::class, "getDetail"])
        ->name("detial");
    $request->put("{id}", [ProductController::class, "update"])->name("edit");
    $request->post("", [ProductController::class, "insert"])->name("create");
    $request
        ->delete("delete/{id}", [ProductController::class, "delete"])
        ->name("delete");
    $request
        ->delete("admin/{id}", [ProductController::class, "getDetailAdmin"])
        ->name("admin.detail");
});

Route::group(["prefix" => "/order", "as" => "o."], function ($request) {
    $request->get("all", [OrderController::class, "index"])->name("all");
    $request
        ->get("detail/{id}", [OrderController::class, "getDetail"])
        ->name("detial");
    $request->put("{id}", [OrderController::class, "update"])->name("edit");
    $request->post("", [OrderController::class, "insert"])->name("create");
    $request
        ->delete("delete/{id}", [OrderController::class, "delete"])
        ->name("delete");
});

Route::group(["prefix" => "/payment", "as" => "pt."], function ($request) {
    $request->get("all", [PaymentController::class, "index"])->name("all");
    $request
        ->get("detail/{id}", [PaymentController::class, "getDetail"])
        ->name("detial");
    $request->put("{id}", [PaymentController::class, "update"])->name("edit");
    $request->post("", [PaymentController::class, "insert"])->name("create");
    $request
        ->delete("delete/{id}", [PaymentController::class, "delete"])
        ->name("delete");
});

Route::group(["prefix" => "/inventory-order", "as" => "o."], function (
    $request,
) {
    $request
        ->get("all", [InventoryOrderController::class, "index"])
        ->name("all");
    $request
        ->get("detail/{id}", [InventoryOrderController::class, "getDetail"])
        ->name("detial");
    $request
        ->put("{id}", [InventoryOrderController::class, "update"])
        ->name("edit");
    $request
        ->post("", [InventoryOrderController::class, "insert"])
        ->name("create");
    $request
        ->delete("delete/{id}", [InventoryOrderController::class, "delete"])
        ->name("delete");
});
