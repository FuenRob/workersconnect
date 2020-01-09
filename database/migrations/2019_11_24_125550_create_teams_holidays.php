<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsHolidays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_holidays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_company');
            $table->integer('id_team');
            $table->integer('id_user');
            $table->date('start');
            $table->date('finish');
            $table->integer('id_type')->default(1);
            $table->string('status')->default("pending");
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
        Schema::dropIfExists('teams_holidays');
    }
}
