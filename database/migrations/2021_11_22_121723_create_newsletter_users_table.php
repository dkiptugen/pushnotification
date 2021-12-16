<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterUsersTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('newsletter_users', function (Blueprint $table) {
                    $table->id();
                    $table->string('email');
                    $table->tinyInteger('is_subscribed')->default(1);
                    $table->unsignedBigInteger('newsletter_product_id');
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
                Schema::dropIfExists('newsletter_users');
            }
    }
