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
        Schema::create("payment", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("payment_method_id"); // later i will update with some other type.

            $table->decimal("amount", 30, 2);
            $table->string("transaction_id")->nullable()->deafult(""); // when people give cash this can be null ////
            $table->enum("payment_status", [
                "pending",
                "completed",
                "failed",
                "refunded",
            ]);
            $table->timestampTz("payment_date");
            $table->json("gateway_response");
            $table->string("gateway_provider");
            $table
                ->foreign("order_id")
                ->references("id")
                ->on("orders")
                ->cascadeOnDelete();
            $table
                ->foreign("payment_method_id")
                ->references("id")
                ->on("payment_methods")
                ->cascadeOnDelete();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("payment");
    }
};
