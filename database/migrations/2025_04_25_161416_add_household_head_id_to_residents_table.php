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
            $table->unsignedBigInteger('household_head_id')->nullable()->after('household_id');
            $table->foreign('household_head_id')->references('id')->on('residents')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropForeign(['household_head_id']);
            $table->dropColumn('household_head_id');
        });
    }
};
