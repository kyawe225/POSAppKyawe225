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
        Schema::create("product_category", function (Blueprint $table) {
            $table->id();
            $table->string("name", 225);
            $table->string("description", 225);
            $table->unsignedBigInteger("parent_category_id")->nullable();
            $table
                ->foreign("parent_category_id")
                ->references("id")
                ->on("product_category")
                ->cascadeOnDelete();
            $table->boolean("is_active")->default(true);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("product_category");
    }
};
