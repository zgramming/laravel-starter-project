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
        Schema::create(Constant::TABLE_MST_CATEGORY, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('master_category_id')->nullable();
            $table->string('code',50)->unique();
            $table->string('name',100);
            $table->text('description')->nullable();
            $table->enum('status',Constant::STATUSENUM)->default('active');
            $table->foreign('master_category_id')->references('id')->on(Constant::TABLE_MST_CATEGORY)->cascadeOnDelete();
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
        Schema::dropIfExists(Constant::TABLE_MST_CATEGORY);
    }
};
