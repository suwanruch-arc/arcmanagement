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
            $table->string('file_name', 255);
            $table->string('origin_name', 255);
            $table->string('extension', 255);
            $table->string('path', 255);
            $table->integer('size');
            $table->bigInteger('table_id')->index();
            $table->string('table_name', 255)->index();
            $table->string('type', 255);
            $table->enum('status', ["active", "inactive"])->default('active');
            $table->softDeletes();
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
