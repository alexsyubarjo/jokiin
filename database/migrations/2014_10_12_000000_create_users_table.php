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
        Schema::create("users", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("username")->nullable();
            $table->string("email", 250)->unique();
            $table->timestamp("email_verified_at")->nullable();
            $table->string("password");
            $table->string("nomor_hp")->nullable();
            $table->string("saldo")->default("0");
            $table->string("saldo_employer")->default("0");
            $table->string("provider")->nullable();
            $table->string("provider_id")->nullable();
            $table->text("rekening")->nullable();
            $table->enum("role", ["Worker", "Employer"])->default("Worker");
            $table->string("kode_referral")->nullable();
            $table->timestamp("last_seen")->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("users");
    }
};
