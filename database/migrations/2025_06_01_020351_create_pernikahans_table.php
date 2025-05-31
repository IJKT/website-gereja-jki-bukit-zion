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
        Schema::create('pernikahan', function (Blueprint $table) {
            $table->string('id_pernikahan', 10);
            $table->foreign('id_pernikahan', 'pernikahan_pengajuan_jemaat_id')->references('id_pengajuan')->on('pengajuan_jemaat');
            $table->string('id_jemaat_p', 10);
            $table->foreign('id_jemaat_p', 'pernikahan_jemaat_p_id')->references('id_jemaat')->on('jemaat');
            $table->string('id_jemaat_w', 10);
            $table->foreign('id_jemaat_w', 'pernikahan_jemaat_w_id')->references('id_jemaat')->on('jemaat');
            $table->string('id_pendeta', 10)->nullable();
            $table->foreign('id_pendeta', 'pernikahan_pelayan_id')->references('id_pelayan')->on('pelayan');
            $table->text('komentar_pernikahan')->nullable();
            $table->dateTime('tgl_pernikahan');
            $table->unique(['id_pernikahan', 'id_jemaat_p', 'id_jemaat_w'], 'unique_pernikahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pernikahan');
    }
};
