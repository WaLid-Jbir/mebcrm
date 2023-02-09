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
        Schema::create('infobanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherant_id')->constrained()->onDelete('cascade');
            $table->string('titulaire');
            $table->string('adresse');
            $table->string('ville');
            $table->string('zip');
            $table->string('pays');
            $table->string('email');
            $table->string('telephone');
            $table->string('fixe');
            $table->string('iban');
            $table->string('bic');
            $table->string('prelevement');
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
        Schema::dropIfExists('infobanks');
    }
};
