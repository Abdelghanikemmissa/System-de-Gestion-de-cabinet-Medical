<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            // Lien vers la table users (Clé étrangère)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Attributs de ta classe Patient dans l'UML
            $table->date('date_naissance');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('sexe');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};