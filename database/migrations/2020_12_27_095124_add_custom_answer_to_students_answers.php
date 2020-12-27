<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomAnswerToStudentsAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studento_atsakymai', function (Blueprint $table) {
            $table->string('custom_answer')->nullable();
            $table->integer('test_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studento_atsakymai', function (Blueprint $table) {
            //
        });
    }
}
