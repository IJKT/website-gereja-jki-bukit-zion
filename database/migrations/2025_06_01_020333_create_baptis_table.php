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
        Schema::create('baptis', function (Blueprint $table) {
            $table->string('id_baptis', 10);
            $table->foreign('id_baptis', 'baptis_pengajuan_jemaat_id')->references('id_pengajuan')->on('pengajuan_jemaat')->onDelete('cascade');
            $table->string('id_pembaptis', 10)->nullable();
            $table->foreign('id_pembaptis', 'baptis_pembaptis_id')->references('id_pelayan')->on('pelayan')->onDelete('cascade');
            $table->string('preferensi_nama_baptis', 20)->nullable();
            $table->string('id_pengajar', 10);
            $table->foreign('id_pengajar', 'baptis_pengajar_id')->references('id_pelayan')->on('pelayan')->onDelete('cascade');
            $table->text('komentar_baptis')->nullable();
            $table->dateTime('tgl_baptis')->nullable();
            $table->integer('nomor_cetak')->nullable();
            $table->unique(['id_baptis'], 'unique_pernikahan');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptis');
    }
};
