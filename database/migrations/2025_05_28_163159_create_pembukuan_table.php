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
        Schema::create('pembukuan', function (Blueprint $table) {
            $table->string('id_pembukuan', 10)->primary();
            $table->string('jenis_pembukuan', 15);
            $table->integer('nominal_pembukuan')->default(0);
            $table->date('tgl_pembukuan');
            $table->text('deskripsi_pembukuan');
            $table->integer('verifikasi_pembukuan')->default(0);
            $table->text('catatan_pembukuan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembukuan');
    }
};
