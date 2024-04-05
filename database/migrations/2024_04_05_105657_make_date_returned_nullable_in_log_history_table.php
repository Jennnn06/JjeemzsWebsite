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
        Schema::table('log_history', function (Blueprint $table) {
            $table->string('DATE_RETURNED')->nullable()->change();
            $table->string('RETURNEE')->nullable()->change();
            $table->string('BORROWER_SIGNATURE')->nullable()->change();
            $table->string('RETURNEE_SIGNATURE')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_history', function (Blueprint $table) {
            //
        });
    }
};
