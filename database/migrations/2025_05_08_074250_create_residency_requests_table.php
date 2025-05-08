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
        Schema::create('residency_requests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('birthdate');
            $table->integer('age');
            $table->text('address');
            $table->string('contact_number');
            $table->integer('years_residency');
            $table->text('purpose');
            $table->date('date_requested');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residency_requests');
    }
};
