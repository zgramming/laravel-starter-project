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
        Schema::create(Constant::TABLE_APP_ACCESS_MODUL, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('app_group_user_id');
            $table->unsignedInteger('app_modul_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('app_group_user_id')->references('id')->on(Constant::TABLE_APP_GROUP_USER)->cascadeOnDelete();
            $table->foreign('app_modul_id')->references('id')->on(Constant::TABLE_APP_MODUL)->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Constant::TABLE_APP_ACCESS_MODUL);
    }
};
