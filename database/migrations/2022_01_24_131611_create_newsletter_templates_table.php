<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterTemplatesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('newsletter_templates', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->unsignedBigInteger('product_id')->index();
                    $table->bigInteger('noofposts');
                    $table->tinyInteger('status');
                    $table->text('template_loc');
                    $table->unsignedBigInteger('user_id')->index();
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
                Schema::dropIfExists('newsletter_templates');
            }
    }