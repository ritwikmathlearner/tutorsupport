<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->unique();
            $table->string('subject');
            $table->string('title');
            $table->string('country');
            $table->string('reference_style');
            $table->integer('reference_number');
            $table->dateTime('dead_line');
            $table->dateTime('upload_time')->nullable();
            $table->text('deliverable')->nullable();
            $table->integer('word_count');
            $table->string('word_distribution');
            $table->string('case_study');
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->index();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
