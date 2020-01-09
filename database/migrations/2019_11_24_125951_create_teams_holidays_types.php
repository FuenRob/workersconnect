<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsHolidaysTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_holidays_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('teams_holidays_types')->insert(
            array(
                'name' => 'Vacaciones'
            )
        );

        DB::table('teams_holidays_types')->insert(
            array(
                'name' => 'Asuntos Personales'
            )
        );

        DB::table('teams_holidays_types')->insert(
            array(
                'name' => 'Mudanza'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams_holidays_types');
    }
}
