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
        Schema::create('frais', function (Blueprint $table) {
            $table->id();
            $table->string('level', 191)->unique();
            $table->decimal('frais_inscription', 16, 2, true);
            $table->decimal('frais_reinscription', 16, 2, true);
            $table->decimal('frais_scolarite', 16, 2, true);
            $table->decimal('frais_scolarite_tranche1', 16, 2, true);
            $table->decimal('frais_scolarite_tranche2', 16, 2, true);
            $table->decimal('frais_scolarite_tranche3', 16, 2, true);
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frais');
    }
};
