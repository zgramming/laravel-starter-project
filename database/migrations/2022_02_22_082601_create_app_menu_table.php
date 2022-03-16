<?php

use App\Constant\Constant;
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
        Schema::create(Constant::TABLE_APP_MENU, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_modul_id');
            $table->unsignedInteger('app_menu_id_parent')->nullable();
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->string('route', 100)->unique();
            $table->integer('order');
            $table->string('icon_name', 50)->nullable();
            $table->enum('status', ['active', 'not_active', 'none']);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('app_modul_id')->references('id')->on(Constant::TABLE_APP_MODUL)->cascadeOnDelete();
            $table->foreign('app_menu_id_parent')->references('id')->on(Constant::TABLE_APP_MENU)->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Constant::TABLE_APP_MENU);
    }
};
