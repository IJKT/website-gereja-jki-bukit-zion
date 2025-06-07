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
        Schema::create('jemaat', function (Blueprint $table) {
            $table->string('id_jemaat', 10)->primary();
            $table->string('username', 50)->unique();
            $table->foreign('username')->references('username')->on('users');
            $table->string('nama_jemaat', 50);
            $table->string('jk_jemaat', 1);
            $table->string('nik_jemaat', 16);
            $table->string('tmpt_lahir_jemaat', 50);
            $table->date('tgl_lahir_jemaat');
            $table->string('telp_jemaat', 20);
            $table->datetime('tgl_daftar_jemaat');
            $table->string('email_jemaat', 50)->unique();
            $table->string('alamat_jemaat', 100);
            $table->string('pekerjaan_jemaat', 100)->nullable();
            $table->string('wilayah_komsel_jemaat', 100)->nullable();
            $table->string('hak_akses_jemaat')->default('Jemaat');
            $table->boolean('status_jemaat')->default(1);
            $table->timestamps();
        });
    }
    /*******  d3ac5b51-20ba-4444-b71f-defa78fc7d8f  *******/

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jemaat');
    }
};
