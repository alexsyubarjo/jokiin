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
        Schema::create("deposit", function (Blueprint $table) {
            $table->id();
            $table->string("kode");
            $table->unsignedBigInteger("user_id");
            $table->string("nominal");
            $table->string("bank");
            $table->string("metode");
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("deposit");
    }
};
