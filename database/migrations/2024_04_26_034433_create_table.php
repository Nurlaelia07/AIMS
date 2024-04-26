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
        Schema::create('parameter', function (Blueprint $table) {
            $table->id('id_parameter');
            $table->unsignedBigInteger('fk_id_parameter_ph_air');
            $table->unsignedBigInteger('fk_id_parameter_ppm_air');
            $table->unsignedBigInteger('fk_id_parameter_suhu');
            $table->timestamps();
            
            $table->foreign('fk_id_parameter_ph_air')->references('id_paramater_ph_air')->on('parameter_ph_air')->onDelete('cascade');
            $table->foreign('fk_id_parameter_ppm_air')->references('id_paramater_ppm_air')->on('parameter_ppm_air')->onDelete('cascade');
            $table->foreign('fk_id_parameter_suhu')->references('id_paramater_suhu')->on('parameter_suhu')->onDelete('cascade');
        });

        Schema::create('parameter_ph_air', function (Blueprint $table) {
            $table->id('id_paramater_ph_air');
            $table->double('max_ph_air');
            $table->double('min_ph_air');
            $table->timestamps();
        });

        Schema::create('parameter_ppm_air', function (Blueprint $table) {
            $table->id('id_paramater_ppm_air');
            $table->double('max_ppm_air');
            $table->double('min_ppm_air');
            $table->timestamps();
        });

        Schema::create('parameter_suhu', function (Blueprint $table) {
            $table->id('id_paramater_suhu');
            $table->double('max_suhu');
            $table->double('min_suhu');
            $table->timestamps();
        });

        Schema::create('ph_air', function (Blueprint $table) {
            $table->id('id_ph');
            $table->double('ph_air');
            $table->date('tanggal');
            $table->time('waktu');
            $table->timestamps();
        });

        Schema::create('suhu', function (Blueprint $table) {
            $table->id('id_suhu');
            $table->double('suhu');
            $table->date('tanggal');
            $table->time('waktu');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 20);
            $table->string('password', 255);
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
        Schema::dropIfExists('suhu');
        Schema::dropIfExists('ph_air');
        Schema::dropIfExists('parameter_suhu');
        Schema::dropIfExists('parameter_ppm_air');
        Schema::dropIfExists('parameter_ph_air');
        Schema::dropIfExists('parameter');
    }
};