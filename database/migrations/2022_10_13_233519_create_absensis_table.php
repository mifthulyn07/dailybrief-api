<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('absen_masuk')->nullable();
            $table->time('absen_pulang')->nullable();
            $table->text('keterangan_absen_masuk')->nullable();
            $table->text('keterangan_absen_pulang')->nullable();
            $table->enum('status_absen_masuk', ['Hadir', 'Absen'])->nullable();
            $table->enum('status_absen_pulang', ['Hadir', 'Absen'])->nullable();
            $table->time('keterlambatan_absen_masuk')->nullable();
            $table->time('keterlambatan_absen_pulang')->nullable();
            $table->timestamps();

            // relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensis');
    }
};
