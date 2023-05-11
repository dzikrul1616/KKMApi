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
        Schema::create('pesakits', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('nama');
            $table->string('tanggal_lahir');
            $table->integer('umur');
            $table->string('diagnosis');
            $table->string('jenis_kelamin');
            $table->integer('height');
            $table->integer('weight');
            $table->integer('age');
            $table->string('negeri');
            $table->integer('kode_pos');
            $table->longText('note')->nullable(); 
            $table->integer('house_number');
            $table->string('phone_number', 15)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesakits');
    }
};
