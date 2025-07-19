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
        Schema::create("cupon_usage_records", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cupon_id");
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("cms_user_id");
            $table->string("customer_id")->nullable()->default("");
            $table->timestampTz("usage_date");
            $table->decimal("discount_value", 30, 2);
            $table->enum("discount_type", ["fixed_amount", "percentage"]);
            $table
                ->foreign("cms_user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete();
            $table
                ->foreign("order_id")
                ->references("id")
                ->on("orders")
                ->cascadeOnDelete();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("cupon_usage_records");
    }
};
