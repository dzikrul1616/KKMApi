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
        Schema::create('batch_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->integer('tasker_id');
            $table->integer('batch_id');
            $table->integer('hospital_id');
            $table->string('status_batch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_broadcasts');
    }
};
