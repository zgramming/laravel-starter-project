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
        Schema::create('app_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_modul_id');
            $table->unsignedInteger('app_menu_id_parent');
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->string('url_controller', 100)->unique();
            $table->integer('order');
            $table->string('icon_name', 50)->nullable();
            $table->enum('status', ['active', 'not_active', 'none']);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->foreign('app_modul_id')->references('id')->on('app_modul');
            $table->foreign('app_menu_id_parent')->references('id')->on('app_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_menu');
    }
};
