<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('full_name');
            $table->json('data');
            $table->string('status')->default('pending');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permits');
    }
};