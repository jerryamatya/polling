<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name', 250);
            $table->text('description')->nullable();
            $table->string('image',500)->nullable();
            $table->dateTime('start_at', 0);
            $table->dateTime('expires_at', 0);	
            $table->enum('type', ['poll', 'quiz']);
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
        Schema::dropIfExists('topics');
    }
}
