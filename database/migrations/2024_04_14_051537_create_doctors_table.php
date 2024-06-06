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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('gender', ['male','female'])->default('male');
            $table->enum('owner', ['yes','no'])->default('no');
            $table->string('specialization');
            $table->string('clinic');
            $table->string('personal_id')->unique();
            $table->string('license_number');
            $table->string('tax_number');
            $table->string('doctor_papers')->nullable();
            $table->string('personal_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
