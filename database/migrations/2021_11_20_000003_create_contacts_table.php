<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('nationality');
            $table->string('salutation');
            $table->string('source');
            $table->string('status');
            $table->string('lead_status')->nullable();
            $table->string('mobile');
            $table->string('alternate_mobile')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

