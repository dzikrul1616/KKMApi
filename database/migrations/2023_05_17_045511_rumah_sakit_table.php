<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRumahSakitTable extends Migration
{
    public function up()
    {
        Schema::create('rumah_sakit', function (Blueprint $table) {
            $table->id();
            $table->string('rumah_sakit');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rumah_sakit');
    }
}
