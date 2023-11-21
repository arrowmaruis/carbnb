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
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('fabricant');
            $table->string('model');
            $table->string('categorie');
            $table->string('portieres');
            $table->string('sieges');
            $table->string('transmission');
            $table->string('Performances');
            $table->string('carburant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
