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
        Schema::create('adherants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('civilite');
            $table->string('nom');
            $table->string('prenom');
            $table->date('naissance');
            $table->string('email');
            $table->string('adresse');
            $table->string('ville');
            $table->string('zip');
            $table->string('telephone');
            $table->string('fixe');
            $table->string('flag')->default('devis cree');
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
        Schema::dropIfExists('adherants');
    }
};
