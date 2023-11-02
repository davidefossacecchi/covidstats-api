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
        Schema::create('province_data', function (Blueprint $table) {
            $table->unsignedBigInteger('locality_id');
            $table->integer('total_cases');
            $table->date('date');
            $table->timestamps();
            $table->foreign('locality_id')->references('id')->on('locality');
            $table->primary(['locality_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('province_data');
    }
};
