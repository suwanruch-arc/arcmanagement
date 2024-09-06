<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('keyword', 10)->unique();
            $table->text('tandc')->nullable();
            $table->enum('status', ["active", "inactive"]);
            $table->foreignId('banner_id')->nullable()->constrained('files');
            $table->foreignId('template_id')->nullable()->constrained('files');
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
        Schema::dropIfExists('shops');
    }
}
