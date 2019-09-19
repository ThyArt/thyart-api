<?php

use App\Gallery;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkWithGalleryInsteadOfUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->unsignedInteger('gallery_id');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->unsignedInteger('gallery_id');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->unsignedInteger('gallery_id');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('name')->default('')->change();
            $table->string('address')->default('')->change();
            $table->string('phone')->default('')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('gallery_id');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();


        Schema::table('galleries', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->dropColumn('name');
            $table->dropColumn('address');
            $table->dropColumn('phone');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gallery_id']);
            $table->dropColumn('gallery_id');
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->dropForeign(['gallery_id']);
            $table->dropColumn('gallery_id');
        });

        Schema::table('artists', function (Blueprint $table) {

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->dropForeign(['gallery_id']);
            $table->dropColumn('gallery_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->dropForeign(['gallery_id']);
            $table->dropColumn('gallery_id');
        });

        Schema::enableForeignKeyConstraints();
    }
}
