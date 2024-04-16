<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_ecode', function (Blueprint $table) {
            $table->id();
            $table->string('date_lot',10)->index();
            $table->integer('number_lot')->index();
            $table->string('type',10)->index();
            $table->string('code', 255)->unique();
            $table->integer('value');
            $table->string('unique', 255)->unique();
            $table->string('path',255)->index();
            $table->string('full_path',255)->index();
            $table->dateTime('expire_date');
            $table->text('description')->nullable();
            $table->integer('owner_id')->nullable()->unsigned();
            $table->integer('shop_id')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
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
        Schema::dropIfExists('warehouse_ecode');
    }
}
