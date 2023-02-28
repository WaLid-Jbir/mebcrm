<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_suivis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherant_id')->constrained()->onDelete('cascade');
            $table->string('audio');
            $table->string('audio_status')->default('en attent de fichier');
            $table->string('motif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospect_suivis');
    }
};
