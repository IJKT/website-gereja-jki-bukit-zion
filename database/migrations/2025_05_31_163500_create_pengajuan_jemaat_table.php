<?php

use App\Models\Jemaat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_jemaat', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->string('id_pengajuan', 10)->primary();
            $table->string('id_jemaat', 10);
            $table->foreign('id_jemaat', 'pengajuan_jemaat_jemaat_id')->references('id_jemaat')->on('jemaat');
            $table->string('jenis_pengajuan', 10);
            $table->integer('verifikasi_pengajuan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_jemaat');
    }
};
