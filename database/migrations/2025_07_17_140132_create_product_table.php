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
        Schema::create("product", function (Blueprint $table) {
            $table->id();
            $table->string("name", 225);
            $table->text("description");
            $table->string("sku", 100)->unique();
            $table->unsignedBigInteger("category_id");
            $table
                ->foreign("category_id")
                ->references("id")
                ->on("product_category")
                ->cascadeOnDelete();

            $table->unsignedBigInteger("default_supplier_id");
            $table
                ->foreign("default_supplier_id")
                ->references("id")
                ->on("provider")
                ->cascadeOnDelete();
            $table->decimal("price", 20, 2);
            $table->decimal("cost", 20, 2);
            $table->integer("reorder_point")->default(0);
            $table->string("image_url", 225);
            $table->json("attribute");
            $table->json("attribute_type");
            $table->enum("status", ["active", "inactive"]);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("product");
    }
};
