<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->text('thumburl');
            $table->text('message');
            $table->timestamp('publishdate');
            $table->timestamp('senddate')->nullable();
            $table->unsignedBigInteger('deliveries')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('moderated')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('approver')->default(0);
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
        Schema::dropIfExists('contents');
    }
}
