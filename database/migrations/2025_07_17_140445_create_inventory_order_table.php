<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("inventory_order", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("supplier_id");
            $table->unsignedBigInteger("product_id");
            $table
                ->foreign("product_id")
                ->references("id")
                ->on("product")
                ->cascadeOnDelete();
            $table
                ->foreign("supplier_id")
                ->references("id")
                ->on("provider")
                ->cascadeOnDelete();
            $table->date("order_date");
            $table->timestampTz("actual_delivery_date")->nullable();
            $table->unsignedBigInteger("total_amount");
            $table->enum("status", [
                "pending",
                "ordered",
                "shipped",
                "delivered",
                "cancelled",
            ]);
            $table->text("notes");
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("inventory_order");
    }
};
