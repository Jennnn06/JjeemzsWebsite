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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('ITEM_IMAGE')->nullable();
            $table->string('ITEM_NAME');
            $table->string('BRAND')->nullable();
            $table->string('COLOR');
            $table->integer('QUANTITY');
            $table->string('STATUS');
            $table->string('AVAILABLE');
            $table->string('IN_OUT');
            $table->string('REASON')->nullable();
            $table->string('NOTE')->nullable();
            $table->string('FOLDER')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
