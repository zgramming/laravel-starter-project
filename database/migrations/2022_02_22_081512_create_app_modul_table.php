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
        Schema::create('app_modul', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->integer('order');
            $table->string('pattern', 100);
            $table->string('icon_name', 50)->nullable();
            $table->enum('status', ['active', 'not_active', 'none']);
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('app_modul');
    }
};
