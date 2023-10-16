<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('contact_number')->nullable();
            $table->foreignId('partner_id')->nullable()->constrained('partners')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->enum('position', ["admin", "leader", "staff"]);
            $table->enum('role', ["admin", "moderator", "user"]);
            $table->enum('status', ["active", "inactive"]);
            $table->enum('from', ["ecp", "s95"]);
            $table->string('remember_token');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('users');
    }
}
