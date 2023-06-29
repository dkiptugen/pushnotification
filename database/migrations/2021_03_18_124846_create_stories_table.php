<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->string('thumbnail');
            $table->text('summary')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->bigInteger('deliveries')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamp('publishdate');
            $table->bigInteger('clicks')->default(0);
            $table->integer('ttl')->default(15);
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('stories');
    }
}
