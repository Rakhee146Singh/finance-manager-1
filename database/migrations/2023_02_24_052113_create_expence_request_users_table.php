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
        Schema::create('expence_request_users', function (Blueprint $table) {
            $table->char('expence_request_id', 36);
            $table->foreign('expence_request_id')->references('id')->on('expence_requests');
            $table->char('user_id', 36);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expence_request_users');
    }
};
