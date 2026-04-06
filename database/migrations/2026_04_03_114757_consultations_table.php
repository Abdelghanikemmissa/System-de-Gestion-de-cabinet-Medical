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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id(); // id : int
            $table->foreignId('rendezvous_id')->constrained('rendez_vous')->onDelete('cascade'); // -rendezvous_id : int
            $table->dateTime('date_consultation'); // -date_consultation : datetime
            $table->text('compte_rendu'); // -compte_rendu : text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
