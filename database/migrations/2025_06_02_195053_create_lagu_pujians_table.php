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
        Schema::create('lagu_pujian', function (Blueprint $table) {
            $table->string('id_lagu', 10)->primary();
            $table->string('nama_lagu', 50);
            $table->string('link_lagu', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lagu_pujian');
    }
};
