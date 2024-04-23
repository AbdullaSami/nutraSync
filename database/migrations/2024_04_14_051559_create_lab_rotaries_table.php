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
        Schema::create('lab_rotaries', function (Blueprint $table) {
            $table->id();
            $table->string('lab_rotary_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('analysis');
            $table->string('name');
            $table->string('contact_person');
            $table->string('contact_number');
            $table->string('tax_number');
            $table->string('lab_papers');
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_rotaries');
    }
};
