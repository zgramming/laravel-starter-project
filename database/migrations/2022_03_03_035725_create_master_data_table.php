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
        Schema::create('master_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('master_category_id');
            $table->string('master_category_code',50);
            $table->string('code',50)->unique();
            $table->string('name',100);
            $table->text('description')->nullable();
            $table->enum('status', Constant::STATUSENUM)->default('active');
            $table->integer('order');
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
            $table->foreign('master_category_id')->references('id')->on('master_category')->cascadeOnDelete();
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
        Schema::dropIfExists('master_data');
    }
};
