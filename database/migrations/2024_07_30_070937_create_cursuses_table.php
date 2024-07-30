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
        Schema::create('cursuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('annee_id');
            $table->foreign('annee_id')->references('id')->on('annees')->onDelete('cascade');
            $table->string('level')->nullable();
            $table->string('serie')->nullable();
            $table->string('resultat')->default('En attente');
            $table->unsignedBigInteger('eleve_id');
            $table->foreign('eleve_id')->references('id')->on('eleves')->onDelete('cascade');
            $table->unsignedBigInteger('classe_id')->nullable();
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursuses');
    }
};
