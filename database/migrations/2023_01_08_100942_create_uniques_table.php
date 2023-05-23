<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uniques', function (Blueprint $table) {
            $table->id();
            $table->string('refid');
            $table->integer('lot');
            $table->string('template_type',3);
            $table->string('campaign_keyword', 3)->index();
            $table->string('privilege_keyword', 5)->index();
            $table->string('shop_keyword', 2)->index();
            $table->string('owner_keyword', 5)->index();
            $table->string('short_unique', 5)->unique();
            $table->string('full_unique', 15)->unique();
            $table->string('msisdn', 11)->nullable();
            $table->string('code');
            $table->text('info');
            $table->enum('flag', ["ok", "cancel", "deviate"]);
            $table->enum('is_use', ["yes", "no"]);
            $table->dateTime('register_date');
            $table->dateTime('first_view_date')->nullable();
            $table->dateTime('redeem_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->foreignId('campaign_id')->constrained('campaigns');
            $table->foreignId('privilege_id')->constrained('privileges');
            $table->foreignId('shop_id')->constrained('shops');
            $table->foreignId('owner_id')->constrained('departments');
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
        Schema::dropIfExists('uniques');
    }
}
