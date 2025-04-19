<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('residents', function (Blueprint $table) {
            // First make sure the column exists
            if (!Schema::hasColumn('residents', 'household_id')) {
                $table->unsignedBigInteger('household_id')->nullable();
            }
            
            // Add foreign key constraint
            $table->foreign('household_id')
                  ->references('id')
                  ->on('households')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropColumn('household_id');
        });
    }
};