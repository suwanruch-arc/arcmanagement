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
            $table->string('username',100)->unique();
            $table->string('password');
            $table->string('contact_number')->nullable();

            $table->enum('position', ["admin", "leader", "employee"])->default('employee');
            $table->enum('role', ["admin", "moderator", "user"])->default('user');
            $table->enum('status', ["active", "inactive"])->default('active');
            $table->enum('from', ["ecp", "s95"])->default('ecp');

            $table->foreignId('partner_id')->nullable()->constrained('partners')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->cascadeOnUpdate()->nullOnDelete();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
