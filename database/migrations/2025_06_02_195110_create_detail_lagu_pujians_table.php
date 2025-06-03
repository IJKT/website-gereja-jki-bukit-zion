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
        Schema::create('detail_lagu_pujian', function (Blueprint $table) {
            $table->string('id_jadwal', 10);
            $table->string('id_lagu', 10);
            $table->integer('urutan_lagu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_lagu_pujian');
    }
};
