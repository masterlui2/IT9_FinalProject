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
        Schema::table('residents', function (Blueprint $table) {
            // 1. Drop the old household column
            $table->dropColumn('household');
            
            // 2. Add household_id as foreign key
            $table->foreignId('household_id')->constrained()->after('birthdate');
            
            // 3. Add relationship column
            $table->string('relationship')->after('household_id');
        });
    }
    
    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropColumn('household_id');
            $table->dropColumn('relationship');
            $table->string('household')->after('birthdate');
        });
    }
};
