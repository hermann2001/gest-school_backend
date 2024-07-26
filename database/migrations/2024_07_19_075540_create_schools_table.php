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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->unique();
            $table->string('logo')->nullable();
            $table->string('email', 191)->unique();
            $table->string('adresse')->nullable();
            $table->string('password');
            $table->bigInteger('phone_number')->unsigned()->nullable()->unique();
            $table->boolean('verified')->default(false);
            $table->boolean('deleted')->default(false);
            $table->boolean('secondaire')->default(true);
            $table->timestamp('verify_link_send')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
