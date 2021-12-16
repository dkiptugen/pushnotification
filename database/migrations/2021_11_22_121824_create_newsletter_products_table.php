<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterProductsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('newsletter_products', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->text('feedlink');
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
                Schema::dropIfExists('newsletter_products');
            }
    }
