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
        Schema::create('rangkuman_firman', function (Blueprint $table) {
            $table->string('id_rangkuman_firman', 10)->primary();
            $table->string('id_pelayan_pnl', 10);
            $table->foreign('id_pelayan_pnl', 'rangkuman_pelayan_id')->references('id_pelayan')->on('pelayan');
            $table->string('nama_narasumber', 50);
            $table->string('judul_rangkuman', 100)->unique();
            $table->string('slug_rangkuman', 100);
            $table->text('isi_rangkuman');
            $table->dateTime('tgl_rangkuman');
            $table->string('gambar_rangkuman', 100)->nullable();
            $table->string('tipe_rangkuman');
            $table->string('kategori_sermons')->nullable();
            $table->boolean('status_rangkuman')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangkuman_firman');
    }
};
