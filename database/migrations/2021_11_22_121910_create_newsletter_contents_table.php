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
                    $table->unsignedBigInteger('newsletter_group_id');
                    $table->string('title');
                    $table->text('link');
                    $table->longText('summary');
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
                Schema::dropIfExists('newsletter_contents');
            }
    }
