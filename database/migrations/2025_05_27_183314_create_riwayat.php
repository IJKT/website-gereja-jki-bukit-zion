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
        Schema::create('riwayat', function (Blueprint $table) {
            $table->string('id_log', 10)->primary();
            $table->string('id_pelayan_creator', 10);
            $table->foreign('id_pelayan_creator')->references('id_pelayan')->on('pelayan');
            // TODO: pokoknya ini nanti dibuat biar bisa ngambil id dari setiap updated table
            $table->string('id_tabel_ubah', 10);
            $table->string('jenis_perubahan', 6);
            $table->dateTime('tgl_perubahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
