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
        Schema::create("tugas", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("post_id");
            $table->longText("comments")->nullable();
            $table->text("bukti")->nullable();
            $table->string("status");
            // Timestamps
            $table->timestamps();

            // Foreign Keys
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users");
            $table
                ->foreign("post_id")
                ->references("id")
                ->on("posts");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tugas");
    }
};
