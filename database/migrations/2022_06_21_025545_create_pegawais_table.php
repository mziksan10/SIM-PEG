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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kab_kota');
            $table->string('provinsi');
            $table->string('kode_pos');
            $table->string('no_hp');
            $table->string('email');
            $table->string('pendidikan');
            $table->string('jurusan')->nullable();
            $table->string('bank')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('tanggal_masuk')->nullable();
            $table->string('status');
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('pegawais');
    }
};
