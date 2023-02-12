<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAturanPresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aturan_presensis', function (Blueprint $table) {
            $table->id();
            $table->string('sesi');
            $table->string('jam_masuk');
            $table->string('batas_max');
            $table->string('batas_min');
            $table->string('late_1');
            $table->string('late_2');
            $table->string('late_3');
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
        Schema::dropIfExists('aturan_presensis');
    }
}
