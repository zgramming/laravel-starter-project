<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('example_child_third', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable();
            $table->string('description',50)->nullable();
            $table->unsignedInteger('example_id');
            $table->foreign('example_id')->references('id')->on('example');
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
        Schema::dropIfExists('example_child_third');
    }
};
