<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArtworkInNewsletter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artwork_newsletter', function (Blueprint $table) {
            $table->integer('artwork_id')->unsigned()->nullable();
            $table->foreign('artwork_id')->references('id')
                ->on('artworks');


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
        Schema::dropIfExists('artwork_newsletter');
    }
}
