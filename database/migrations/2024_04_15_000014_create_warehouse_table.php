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
        Schema::create('ecode_warehouses', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id');
            $table->integer('shop_id');
            $table->string('date_lot')->index();
            $table->integer('number_lot')->index();
            $table->string('type')->index();
            $table->string('code');
            $table->integer('value');
            $table->string('unique')->unique();
            $table->string('file_name');
            $table->string('path');
            $table->dateTime('expire_date');
            $table->text('description')->nullable();
            $table->integer('import_by');
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
