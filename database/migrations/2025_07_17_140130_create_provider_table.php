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
        Schema::create("provider", function (Blueprint $table) {
            $table->id();
            $table->string("name", 225);
            $table->string("contact_person", 225);
            $table->string("email", 200);
            $table->string("phone", 200);
            $table->text("address");
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("postal_code");
            $table->string("country");
            $table->enum("status", ["active", "inactive"]);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("provider");
    }
};
