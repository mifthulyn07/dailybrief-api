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
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->time('absen_masuk');
            $table->time('absen_pulang')->nullable();
            $table->text('keterangan_absen_masuk');
            $table->text('keterangan_absen_pulang')->nullable();
            $table->enum('status_absen_masuk', ['Hadir', 'Absen']);
            $table->enum('status_absen_pulang', ['Hadir', 'Absen']);
            $table->time('keterlambatan_absen_masuk');
            $table->time('keterlambatan_absen_pulang');
            $table->timestamps();

            // relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
