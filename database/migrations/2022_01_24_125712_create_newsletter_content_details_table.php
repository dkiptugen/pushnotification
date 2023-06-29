<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterContentDetailsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('newsletter_content_details', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('newsletter_content_id')->index();
                    $table->string('title');
                    $table->text('link');
                    $table->longText('summary');
                    $table->longText('image_link');
                    $table->integer('listorder');
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
                Schema::dropIfExists('newsletter_content_details');
            }
    }
