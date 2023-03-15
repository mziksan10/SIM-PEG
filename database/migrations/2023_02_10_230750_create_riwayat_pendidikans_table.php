<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPendidikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id');
            $table->string('jenjang');
            $table->string('jurusan');
            $table->string('institusi');
            $table->string('tahun_lulus');
            $table->string('scan_ijazah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_pendidikans');
    }
}
