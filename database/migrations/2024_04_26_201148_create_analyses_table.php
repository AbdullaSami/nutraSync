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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->string('lab_rotary_id');
            $table->foreign('lab_rotary_id')->references('lab_rotary_id')->on('lab_rotaries')->onDelete('cascade');
            $table->string('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->string('analysis');
            $table->enum('status', ['pending','done', 'fail', null])->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
