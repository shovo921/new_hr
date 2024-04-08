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
            $table->string('name');
            $table->string('mobile_no');
            $table->string('email')->nullable();
            $table->string('password');
            $table->enum('type',['system','visitor'])->default('visitor');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->unique(['mobile_no','type']);
            $table->unique(['email','type']);
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
