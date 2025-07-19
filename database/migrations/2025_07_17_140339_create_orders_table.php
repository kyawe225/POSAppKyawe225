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
        Schema::create("orders", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cms_user_id");
            $table->unsignedBigInteger("customer_id")->nullable();
            $table->string("order_number"); // for simplicity i will use uuid for cleaner code
            $table->timestampTz("order_date");
            $table->enum("status", [
                "pending",
                "processing",
                "shipped",
                "delivered",
                "cancelled",
                "refunded",
            ]);
            $table->decimal("subtotal", 30, 2);
            $table->decimal("tax_amount", 30, 2);
            $table->decimal("discount_amount", 30, 2);
            $table->text("notes");
            $table->foreign("cms_user_id")->references("id")->on("users");
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders");
    }
};
