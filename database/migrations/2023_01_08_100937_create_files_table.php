<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('old_name', 255)->nullable();
            $table->string('origin_name', 255);
            $table->string('type', 255);
            $table->string('path', 255);
            $table->integer('size');
            $table->bigInteger('table_id')->index();
            $table->string('table_name', 255)->index();
            $table->string('table_field')->index();
            $table->enum('status', ["active","inactive","delete"]);
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
        Schema::dropIfExists('files');
    }
}
