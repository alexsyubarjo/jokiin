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
        Schema::create("messages", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sender_id");
            $table->unsignedBigInteger("receiver_id");
            $table->text("content");
            $table->string("image")->nullable();
            $table->boolean("seen")->default(false);
            $table->timestamps();

            $table
                ->foreign("sender_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table
                ->foreign("receiver_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("messages");
    }
};
