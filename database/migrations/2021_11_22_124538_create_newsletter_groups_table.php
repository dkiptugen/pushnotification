<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsletter_product_id');
            $table->unsignedBigInteger('newsletter_product_type_id');
            $table->string('name');
            $table->timestamp('publishdate');
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
        Schema::dropIfExists('newsletter_groups');
    }
}
