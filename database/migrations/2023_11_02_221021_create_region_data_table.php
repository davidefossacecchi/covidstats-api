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
        Schema::create('region_data', function (Blueprint $table) {
            $table->unsignedBigInteger('locality_id');
            $dataFields = [
                'icu_patients',
                'hosp_patients',
                'home_isolation',
                'total_positives',
                'healed',
                'deaths',
                'total_cases'
            ];
            foreach ($dataFields as $field) {
                $table->integer($field);
            }

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
        Schema::dropIfExists('region_data');
    }
};
