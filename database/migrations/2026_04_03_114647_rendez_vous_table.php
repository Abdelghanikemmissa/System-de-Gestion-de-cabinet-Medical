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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id(); // id : int
            $table->foreignId('patient_id')->constrained()->onDelete('cascade'); // -patient_id : int
            $table->foreignId('medecin_id')->constrained()->onDelete('cascade'); // -medecin_id : int
            $table->dateTime('date_heure'); // -date_heure : datetime
            $table->string('statut')->default('en attente'); // -statut : string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
