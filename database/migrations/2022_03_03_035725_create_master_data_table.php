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
        Schema::create(Constant::TABLE_MST_DATA, function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("master_data_id")->nullable();
            $table->unsignedInteger('master_category_id');
            $table->string('master_category_code',50);
            $table->string('code',50)->unique();
            $table->string('name',100);
            $table->text('description')->nullable();
            $table->enum('status', Constant::STATUSENUM)->default('active');
            $table->string('parameter1_key',50)->nullable();
            $table->string('parameter2_key',50)->nullable();
            $table->string('parameter3_key',50)->nullable();
            $table->string('parameter4_key',50)->nullable();
            $table->string('parameter5_key',50)->nullable();
            $table->string('parameter1_value',50)->nullable();
            $table->string('parameter2_value',50)->nullable();
            $table->string('parameter3_value',50)->nullable();
            $table->string('parameter4_value',50)->nullable();
            $table->string('parameter5_value',50)->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign("created_by")->references("id")->on(Constant::TABLE_APP_USER)->cascadeOnDelete();
            $table->foreign("updated_by")->references("id")->on(Constant::TABLE_APP_USER)->cascadeOnDelete();
            $table->foreign('master_category_id')->references('id')->on(Constant::TABLE_MST_CATEGORY)->cascadeOnDelete();
            $table->foreign('master_data_id')->references('id')->on(Constant::TABLE_MST_DATA)->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Constant::TABLE_MST_DATA);
    }
};
