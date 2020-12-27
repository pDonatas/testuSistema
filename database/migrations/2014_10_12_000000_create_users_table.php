<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registracija', function (Blueprint $table) {
            $table->id();
            $table->string('vardas');
            $table->string('pavarde');
            $table->string('pastas')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('slaptazodis');
            $table->integer('tipas')->default(1);
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
}
