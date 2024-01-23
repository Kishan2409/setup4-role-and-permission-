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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('name');
            $table->string('mobile_no')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('expiry_date')->nullable();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
