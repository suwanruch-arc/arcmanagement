<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->integer('logo_width')->nullable();
            $table->string('name', 255);
            $table->string('keyword', 10);
            $table->enum('is_main', ['yes', 'no']);
            $table->enum('status', ["active", "inactive"])->default('active');
            $table->foreignId('partner_id')->constrained('partners');
            $table->foreignId('file_id')->nullable()->constrained('files');
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
        Schema::dropIfExists('departments');
    }
}
