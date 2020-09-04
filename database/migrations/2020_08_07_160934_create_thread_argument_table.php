<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadArgumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_argument', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('thread_id');
            $table->unsignedBigInteger('argument_id');
            $table->unique(['thread_id','argument_id']);
            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
            $table->foreign('argument_id')->references('id')->on('arguments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread_argument');
    }
}
