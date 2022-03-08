<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('type');
            $table->string('purpose');
            $table->string('rent_pricing_duration')->nullable();
            $table->string('emirate');
            $table->string('community');
            $table->decimal('price', 15, 2);
            $table->string('beds');
            $table->integer('baths');
            $table->float('plotarea_size', 15, 2)->nullable();
            $table->string('plotarea_size_postfix')->nullable();//
            $table->float('area_size', 15, 2);
            $table->string('area_size_postfix');//
            $table->string('developer')->nullable();
            $table->longText('note')->nullable();
            $table->longText('description');
            $table->string('state')->nullable();
            $table->string('ref')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

