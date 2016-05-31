<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentWordTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('document_word', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->bigIncrements('id');
            $table->integer('document_id')->unsigned();
            $table->integer('word_id')->unsigned();

            $table->double('tf', 15, 8)->unsigned();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('document_word');
    }
}
