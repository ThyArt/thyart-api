<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gallery_id');
            $table->string('subject');
            $table->string('description');
            $table->timestamps();

            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });

        Schema::create('customer_newsletter', function(Blueprint $table)
        {
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')
                ->on('customers');


            $table->integer('newsletter_id')->unsigned()->nullable();
            $table->foreign('newsletter_id')->references('id')
                ->on('newsletters');

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
        Schema::dropIfExists('customer_newsletter');
        Schema::dropIfExists('newsletters');
    }
}
