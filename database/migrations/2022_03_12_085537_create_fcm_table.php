<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcmTable extends Migration
{
    public function up()
    {
        Schema::create('fcm', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('token');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fcm');
    }
}
