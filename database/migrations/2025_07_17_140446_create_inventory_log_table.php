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
        Schema::create("inventory_log", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("inventory_order_id")->nullable();
            $table->unsignedBigInteger("order_id")->nullable();
            $table->unsignedBigInteger("product_id")->nullable();
            $table
                ->foreign("inventory_order_id")
                ->references("id")
                ->on("inventory_order")
                ->cascadeOnDelete();
            $table
                ->foreign("order_id")
                ->references("id")
                ->on("orders")
                ->cascadeOnDelete();
            $table
                ->foreign("product_id")
                ->references("id")
                ->on("product")
                ->cascadeOnDelete();

            $table->unsignedBigInteger("number_of_items");
            $table->enum("transaction_type", [
                "purchase",
                "sale",
                "return",
                "adjustment",
                "damage",
            ]);
            $table->timestampTz("transaction_date");
            $table->unsignedBigInteger("current_stock");
            $table->decimal("unit_cost", 30, 4); // this is the price depends that reacts on time
            $table->text("notes");
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("inventory_log");
    }
};
