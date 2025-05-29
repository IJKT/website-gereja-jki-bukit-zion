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
        Schema::create('pelayan', function (Blueprint $table) {
            $table->string('id_pelayan', 10)->primary();
            $table->string('id_jemaat', 10)->unique();
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat');
            $table->string('hak_akses_pelayan', 50);
            $table->boolean('status_pelayan')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelayan');
    }
};
