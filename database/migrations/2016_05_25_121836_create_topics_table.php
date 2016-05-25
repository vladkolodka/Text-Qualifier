<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('topics', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');

            $table->string('name')->unique();
            $table->integer('language_id')->unsigned();

            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('topics');
    }
}
