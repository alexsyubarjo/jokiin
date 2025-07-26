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
        Schema::create("posts", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("user_id");
            $table->string("image");
            $table->string("title");
            $table->string("slug");
            $table->text("content");
            $table->text("jumlah")->nullable();
            $table->string("komisi");
            $table->text("nama_file_form")->nullable();
            $table->string("status")->default("Berjalan");
            $table->timestamps();

            // Foreign Key
            $table
                ->foreign("category_id")
                ->references("id")
                ->on("categories");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("posts");
    }
};
