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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->enum('employment_type', ['Regular', 'Non-Regular']);
            $table->string('designation');
            $table->string('hdmf_number')->nullable();
            $table->string('sss_number')->nullable();
            $table->string('philhealth_number')->nullable();
            $table->decimal('basic_rate', 10, 2);
            $table->decimal('sss_amount', 10, 2)->nullable();
            $table->decimal('hdmf_amount', 10, 2)->nullable();
            $table->decimal('philhealth_amount', 10, 2)->nullable();
            $table->decimal('other_deductions', 10, 2)->nullable();
            $table->enum('pay_schedule', ['Weekly', '15/30', '10/25']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
