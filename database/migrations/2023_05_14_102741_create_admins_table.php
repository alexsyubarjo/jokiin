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
        Schema::create("admins", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email", 250)->unique();
            $table->string("password");
            $table->timestamp("email_verified_at")->nullable();
            $table->string("is_admin")->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("admins");
    }
};
