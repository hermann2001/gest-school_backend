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
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('matricule')->unsigned()->unique();
            $table->string('photo', 500)->nullable();
            $table->string('nom', 191);
            $table->string('prenoms', 500);
            $table->timestamp('birthday');
            $table->string('adresse')->nullable();
            $table->boolean('masculin')->default(true);
            $table->string('nom_prenoms_pere', 500);
            $table->string('nom_prenoms_mere', 500);
            $table->string('parent_email', 200);
            $table->bigInteger('parent_telephone')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
