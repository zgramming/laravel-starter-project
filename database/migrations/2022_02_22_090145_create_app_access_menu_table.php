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
        Schema::create(Constant::TABLE_APP_ACCESS_MENU, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('app_group_user_id');
            $table->unsignedInteger('app_modul_id');
            $table->unsignedInteger('app_menu_id');

            /// Jangan lupa di casting pada model nantinya menjadi array
            $table->json('allowed_access');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign("created_by")->references("id")->on(Constant::TABLE_APP_USER)->cascadeOnDelete();
            $table->foreign("updated_by")->references("id")->on(Constant::TABLE_APP_USER)->cascadeOnDelete();
            $table->foreign('app_group_user_id')->references('id')->on(Constant::TABLE_APP_GROUP_USER)->cascadeOnDelete();
            $table->foreign('app_modul_id')->references('id')->on(Constant::TABLE_APP_MODUL)->cascadeOnDelete();
            $table->foreign('app_menu_id')->references('id')->on(Constant::TABLE_APP_MENU)->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Constant::TABLE_APP_ACCESS_MENU);
    }
};
