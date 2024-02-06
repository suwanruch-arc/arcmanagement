<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privileges', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('keyword', 10)->unique();
            $table->integer('value');
            $table->integer('lot');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('has_timer', ['yes', 'no']);
            $table->integer('timer_value')->nullable();
            $table->enum('skip_confirm', ['no', 'yes']);
            $table->enum('can_view', ['yes', 'no']);
            $table->enum('default_code', ["qrcode", "barcode", "textcode"]);
            $table->enum('has_detail', ['yes', 'no']);
            $table->text('detail')->nullable();
            $table->text('tandc')->nullable();
            $table->text('settings')->nullable();
            $table->enum('status', ["active", "inactive"]);
            $table->foreignId('campaign_id')->constrained('campaigns');
            $table->foreignId('shop_id')->constrained('shops');
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
        Schema::dropIfExists('privileges');
    }
}
