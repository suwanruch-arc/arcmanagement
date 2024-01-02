<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->enum('connection',['main','db_storage_code','db_95','db_a','db_b']);
            $table->enum('type_query',['std','raw']);
            $table->string('uuid',191)->unique();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('from', 255)->nullable();
            $table->text('where')->nullable();
            $table->text('sql')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
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
        Schema::dropIfExists('reports');
    }
}
