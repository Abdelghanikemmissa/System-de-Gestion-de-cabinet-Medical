<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('CNI')->unique(); // Ta colonne de recherche
            $table->string('nom');           // #nom dans l'UML
            $table->string('prenom');        // #prenom dans l'UML
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');          // admin, medecin, secretaire, patient
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};