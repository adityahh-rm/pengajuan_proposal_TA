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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('judul', 100);
            $table->string('berkas_kp');
            $table->string('berkas');
            $table->integer('status')->default('0'); #0 = Menunggu, #1 = Revisi, #2 = Menunggu Dosen, #3 = Disetujui
            $table->text('feedback')->nullable();
            $table->foreignId('dosen_id')->nullable()->constrained('dosens');
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
        Schema::dropIfExists('proposals');
    }
};
