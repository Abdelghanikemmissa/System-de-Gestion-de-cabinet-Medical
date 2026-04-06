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
        Schema::create('disponibilites', function (Blueprint $table) {
            $table->id(); // id : int
            $table->foreignId('medecin_id')->constrained()->onDelete('cascade'); // -medecin_id : int
            $table->string('jour'); // -jour : string
            $table->time('heure_debut'); // -heure_debut : time
            $table->time('heure_fin'); // -heure_fin : time
            $table->boolean('est_libre')->default(true); // -est_libre : bool
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilites');
    }
};
