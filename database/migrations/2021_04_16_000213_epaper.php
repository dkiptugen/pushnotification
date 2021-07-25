<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Epaper extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epaper', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->string('thumbnail');
            $table->string('summary');
            $table->integer('flag')->default(0);
            $table->integer('offset')->default(0);
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
        Schema::dropIfExists('epaper');
    }
}
