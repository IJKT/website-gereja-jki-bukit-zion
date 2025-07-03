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
        Schema::create('revisi_pengajuan', function (Blueprint $table) {
            $table->string('id_revisi', 10);
            $table->foreign('id_revisi', 'revisi_pengajuan_jemaat_id')->references('id_pengajuan')->on('pengajuan_jemaat')->onDelete('cascade');
            $table->string('id_pengomentar', 10);
            $table->foreign('id_pengomentar', 'pelayan_pengajuan_jemaat_id')->references('id_pelayan')->on('pelayan')->onDelete('cascade');
            $table->text('komentar');
            $table->date('tgl_revisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisi_pengajuan');
    }
};
