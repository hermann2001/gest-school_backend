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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('level')->nullable();
            $table->string('serie')->nullable();
            $table->integer('effectif')->default(25);
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id', 191)->references('id')->on('schools')->onDelete('cascade');
            $table->timestamps();

            // Contrainte d'unicité composite
            $table->unique(['name', 'school_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
