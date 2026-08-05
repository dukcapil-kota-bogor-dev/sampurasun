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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nik');
            $table->string('nama');
            $table->string('no_hp');
            $table->string('jenis_kelamin');
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->foreignId('jenis_layanan_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('detail')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_di_balasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
