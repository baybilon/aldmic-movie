<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public $withinTransaction = false;

    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
        $table->increments('id');
        $table->string('user_id')->unsigned();
        $table->string('imdbID');
        $table->timestamps();

        $table->unique(['user_id', 'imdbID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
