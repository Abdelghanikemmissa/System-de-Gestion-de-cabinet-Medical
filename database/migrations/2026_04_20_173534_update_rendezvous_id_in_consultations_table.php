<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Force la colonne à ne pas être nullable
            $table->unsignedBigInteger('rendezvous_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Remet la colonne en nullable si besoin de faire un rollback
            $table->unsignedBigInteger('rendezvous_id')->nullable()->change();
        });
    }
};