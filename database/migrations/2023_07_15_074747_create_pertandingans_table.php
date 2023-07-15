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
        Schema::create('pertandingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klub_id_1');
            $table->unsignedBigInteger('klub_id_2');
            $table->integer('skor_1');
            $table->integer('skor_2');
            $table->timestamps();

            $table->foreign('klub_id_1')->references('id')->on('klubs');
            $table->foreign('klub_id_2')->references('id')->on('klubs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertandingans');
    }
};
