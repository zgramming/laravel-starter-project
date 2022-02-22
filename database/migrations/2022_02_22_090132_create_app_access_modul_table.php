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
        Schema::create('app_access_modul', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_group_user_id');
            $table->unsignedInteger('app_modul_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->foreign('app_group_user_id')->references('id')->on('app_group_user')->cascadeOnDelete();
            $table->foreign('app_modul_id')->references('id')->on('app_modul')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_access_modul');
    }
};
