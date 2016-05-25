<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('documents', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->text('text');
            $table->boolean('verified')->default(false);
            $table->integer('topic_id')->default(0)->unsigned();

            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('set default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('documents');
    }
}
