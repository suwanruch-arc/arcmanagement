<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_settings', function (Blueprint $table) {
            $table->foreignId('report_id')->constrained('reports');
            $table->enum('is_search', ['yes', 'no']);
            $table->string('label', 255);
            $table->string('field', 255);
            $table->enum('condition', ['LIKE', '=', '>', '>=', '<', '<=']);
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
        Schema::dropIfExists('report_settings');
    }
}
