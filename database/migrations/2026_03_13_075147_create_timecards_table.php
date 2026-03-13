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
        Schema::create('timecards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('date');
            $table->enum('day_type', ['Regular', 'Holiday', 'Special Non-Working Day', 'Special Working Day', 'Rest Day']);
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->decimal('break_hours', 5, 2)->nullable();
            $table->decimal('night_diff_pay', 10, 2)->nullable();
            $table->decimal('total_hours', 5, 2)->nullable();
            $table->decimal('ot_hours', 5, 2)->nullable();
            $table->decimal('ot_pay', 10, 2)->nullable();
            $table->decimal('overall_total', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timecards');
    }
};
