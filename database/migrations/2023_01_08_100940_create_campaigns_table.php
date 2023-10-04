<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    private $color_lists = [
        'red',
        'pink',
        'purple',
        'deep-purple',
        'indigo',
        'blue',
        'light-blue',
        'cyan',
        'teal',
        'green',
        'light-green',
        'lime',
        'yellow',
        'amber',
        'orange',
        'deep-orange',
        'brown',
        'grey',
        'blue-grey',
        'white'
    ];
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
            $table->enum('template_type', ["STD", "CTM"]);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->string('title_alert');
            $table->string('desc_alert');
            $table->enum('main_color', $this->color_lists);
            $table->enum('secondary_color', $this->color_lists);
            $table->enum('redeem_color', $this->color_lists);
            $table->enum('view_color', $this->color_lists);
            $table->enum('expire_color', $this->color_lists);
            $table->enum('already_color', $this->color_lists);
            $table->string('redeem_btn');
            $table->string('view_btn');
            $table->string('expire_btn');
            $table->string('already_btn');
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
