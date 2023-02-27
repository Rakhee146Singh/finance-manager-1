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
        Schema::create('comp_off_requests', function (Blueprint $table) {
            $table->uuid('id', 36)->primary();
            $table->char('financial_year_id', 36);
            $table->char('user_id', 36);
            $table->date('date');
            $table->string('description', 551)->nullable();
            $table->boolean('is_fullday')->default(true);
            $table->boolean('is_approved')->default(false);
            $table->enum('approval_status', ['A', 'R'])->comment('A: Approved, R: Rejected')->nullable();
            $table->char('approval_by', 36)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();


            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approval_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comp_off_requests');
    }
};
