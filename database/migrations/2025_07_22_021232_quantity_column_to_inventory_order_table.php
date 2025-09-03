<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventory_order', function (Blueprint $table) {
            $table->unsignedBigInteger("expected_quantity")->nullable();
            $table->unsignedBigInteger("actual_quantity")->nullable();
            $table->unsignedBigInteger("damage_quantity")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_order', function (Blueprint $table) {
            $table->dropColumn("expected_quantity");
            $table->dropColumn("actual_quantity");
            $table->dropColumn("damage_quantity");
        });
    }
};
