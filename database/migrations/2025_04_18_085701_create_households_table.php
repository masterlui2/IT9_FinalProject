<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->string('purok'); // Neighborhood/zone identifier
            $table->string('address');
            $table->string('household_number')->unique(); // Like "HH-001"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('households');
    }
};
