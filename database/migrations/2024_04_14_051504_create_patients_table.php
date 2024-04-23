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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('patient_id')->unique();
            $table->string('personal_id')->unique();
            $table->string('personal_image')->nullable();
            $table->string('personal_id_front')->nullable();
            $table->string('personal_id_back')->nullable();
            $table->string('prescription');
            $table->date('date_of_birth');
            $table->enum('gender', ['male','female'])->default('male');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->float('muscles_percentage')->nullable();
            $table->float('total_body_fat')->nullable();
            $table->float('total_body_water')->nullable();
            $table->float('bmi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
