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
        Schema::create('log_history', function (Blueprint $table) {
            $table->id();
            $table->string('ITEM');
            $table->string('BRAND');
            $table->string('QUANTITY');
            $table->string('LOCATION');
            $table->string('DATE_BORROWED');
            $table->string('BORROWER');
            $table->string('DATE_RETURNED');
            $table->string('RETURNEE');
            $table->string('BORROWER_SIGNATURE');
            $table->string('RETURNEE_SIGNATURE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
