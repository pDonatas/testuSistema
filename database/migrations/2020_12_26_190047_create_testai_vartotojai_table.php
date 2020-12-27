<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestaiVartotojaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testai_vartotojai', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('test_id');
            $table->date('atlikimoData')->nullable();
            $table->boolean('atliktas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testai_vartotojai');
    }
}
