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
        Schema::create('master_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_category_id');
            $table->string('code',50)->unique();
            $table->string('name',100);
            $table->text('description')->nullable();
            $table->enum('status',Constant::STATUSENUM)->default('active');
            $table->integer('order');
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
        Schema::dropIfExists('master_category');
    }
};
