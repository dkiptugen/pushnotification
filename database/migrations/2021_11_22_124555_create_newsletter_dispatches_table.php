<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterDispatchesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
            {
                Schema::create('newsletter_dispatches', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('newsletter_content_id');
                    $table->unsignedBigInteger('newsletter_subscription_id');
                    $table->tinyInteger('delivery')->default(0);
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
                Schema::dropIfExists('newsletter_dispatches');
            }
    }
