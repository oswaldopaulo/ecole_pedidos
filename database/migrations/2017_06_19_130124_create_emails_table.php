<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo')->length(5)->nullable();
            $table->string('servidor')->length(100)->nullable();
            $table->string('porta')->length(5)->nullable();
            $table->string('caixa')->length(20)->nullable();
            $table->string('email')->length(100)->nullable();
            $table->string('senha')->length(100)->nullable();
            $table->string('parametros')->length(100)->nullable();
            $table->string('uid')->length(20)->nullable();
            $table->string('ativo')->integer(1)->nullable();
            
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
        Schema::dropIfExists('emails');
    }
}
