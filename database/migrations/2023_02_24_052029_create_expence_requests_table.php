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
        Schema::create('expence_requests', function (Blueprint $table) {
            $table->uuid('id', 36)->primary();
            $table->char('financial_year_id', 36);
            $table->foreign('financial_year_id')->references('id')->on('financial_years');
            $table->date('date');
            $table->string('amount');
            $table->text('attachment')->nullable();
            $table->string('description', 551)->nullable();
            $table->boolean('is_approved')->default(false);
            $table->enum('approval_status', ['Paid', 'Unpaid', 'Prepaid'])->nullable();
            $table->char('approval_by', 36)->nullable();
            $table->foreign('approval_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->char('created_by', 36)->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->char('updated_by', 36)->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->char('deleted_by', 36)->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expence_requests');
    }
};
