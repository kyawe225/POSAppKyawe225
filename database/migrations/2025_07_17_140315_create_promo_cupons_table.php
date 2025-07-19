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
        Schema::create("promo_cupons", function (Blueprint $table) {
            $table->id();
            $table->string("cupon_code");
            $table->string("cupon_qr_barcode");
            $table->text("description");
            $table->decimal("discount_value", 10, 2);
            $table->enum("discount_type", ["percentage", "fixed_amount"]);
            $table->decimal("minimum_purchase_amount")->nullable()->default(0);
            $table->decimal("maximum_discount_amount")->nullable()->default(0); // this is tricky let me extend more later;;; more tables and rules
            $table->timestampTz("valid_from");
            $table->timestampTz("valid_until");
            $table->integer("usage_limit")->default(-1);
            $table->integer("usage_count")->default(-1);
            $table->enum("status", ["active", "pause", "expired", "scheduled"]);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("promo_cupons");
    }
};
