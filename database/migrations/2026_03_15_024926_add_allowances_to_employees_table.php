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
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('allowance', 10, 2)->default(0)->after('philhealth_amount');
            $table->decimal('accommodation', 10, 2)->default(0)->after('allowance');
            $table->decimal('load_allowance', 10, 2)->default(0)->after('accommodation');
            $table->decimal('travel_allowance', 10, 2)->default(0)->after('load_allowance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['allowance', 'accommodation', 'load_allowance', 'travel_allowance']);
        });
    }
};
