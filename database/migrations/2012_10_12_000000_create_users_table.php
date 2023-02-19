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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            // $table->unsignedBigInteger('data_id');
            // $table->foreign('data_id')->references('id')->on('data');
            // $table->unsignedBigInteger('kelas_id')->nullable();
            // $table->foreign('kelas_id')->references('id')->on('kelas')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('role')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            // $table->unsignedBigInteger('siswa_id')->nullable();
            // $table->foreign('siswa_id')->references('id')->on('siswa')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            // $table->string('role')->index('role');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
