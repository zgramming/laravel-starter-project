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
        Schema::create(Constant::TABLE_PARAMETER, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('code',50)->unique();
            $table->text('value');
            $table->enum('status',Constant::STATUSENUM)->default('active');
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
        Schema::dropIfExists(Constant::TABLE_PARAMETER);
    }
};
