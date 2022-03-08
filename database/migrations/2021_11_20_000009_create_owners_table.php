<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->string('ref')->nullable();
            $table->string('firstname')->nullable();
            $table->string('emirate_id_number')->nullable();
            $table->string('salutation')->nullable();
            $table->string('lastname')->nullable();
            $table->string('source')->nullable();
            $table->string('email')->nullable();
            $table->string('nationality')->nullable();
            $table->string('mobile')->unique();
            $table->text('projects')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
