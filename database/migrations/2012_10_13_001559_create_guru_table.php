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
        Schema::create('guru', function (Blueprint $table) {
            $table->id('id');
            $table->integer('nip');
            $table->string('nama');
            // $table->primary('nama');
            // $table->string('nip');
            // $table->char('jenis_kelamin');
            // $table->enum('jenis_kelamin',['L' , 'P']);
            $table->char('jenis_kelamin');            
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
        Schema::dropIfExists('guru');
    }
};
