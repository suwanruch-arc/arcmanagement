<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('name');
            $table->string('keyword', 3)->unique();
            $table->enum('template_type', ["STD", "CTMT", "CTMS"]);
            $table->enum('connection', ['db_storage_code', 'db_a', 'db_b']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description')->nullable();
            $table->enum('status', ["active", "inactive"]);
            $table->text('settings');
            $table->foreignId('owner_id')->constrained('departments');
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
        Schema::dropIfExists('campaigns');
    }
}
