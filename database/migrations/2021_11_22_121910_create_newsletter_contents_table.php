<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterContentsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('newsletter_contents', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->unsignedBigInteger('newsletter_template_id')->index();
                    $table->dateTime('send_time');
                    $table->tinyInteger('status')->default(0);
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
                Schema::dropIfExists('newsletter_contents');
            }
    }
