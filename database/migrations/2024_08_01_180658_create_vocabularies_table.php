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
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_sentence')->default(false);
            $table->string('french')->nullable();
            $table->string('serere')->nullable();
            $table->integer('correctly_translated')->nullable(); //value from 1 to 5. 1 means it was correctly tranlated one time, and 5 5 times.
            $table->integer('correctly_understood')->nullable(); //value from 1 to 5. 1 means it was correctly understood one time, and 5 5 times.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentences');
    }
};
