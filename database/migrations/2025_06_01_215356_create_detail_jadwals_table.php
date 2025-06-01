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
        Schema::create('detail_jadwal', function (Blueprint $table) {
            $table->string('id_jadwal', 10);
            $table->foreign('id_jadwal', 'detail_jadwal_jadwal_id')->references('id_jadwal')->on('jadwal_ibadah');
            $table->string('id_pelayan', 10)->nullable();
            $table->foreign('id_pelayan', 'detail_jadwal_pelayan_id')->references('id_pelayan')->on('pelayan');
            $table->string('nama_pendeta_undangan', 50)->nullable();
            /** PELAYAN GEREJA
             * 1 = Pendeta
             * 2 = Worship Leader
             * 3 = Pelayan
             * 4 = Singer
             * 5 = Keyboard
             * 6 = Drum
             * 7 = Bass
             * 8 = Guitar
             */
            /** MULTIMEDIA
             * 9 = Video
             * 10 = Photo
             * 11 = Live Stream
             * 12 = Lyrics
             */
            $table->integer('peran_pelayan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jadwal');
    }
};
