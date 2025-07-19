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
            $table
                ->foreign("supplier_id")
                ->references("id")
                ->on("provider")
                ->cascadeOnDelete();
            $table->date("order_date");
            $table->date("excepted_delivery_date");
            $table->timestampTz("actual_delivery_date");
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
