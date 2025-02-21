<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->enum('gender', ['male','female','other'])->default('male');
            $table->string('lang')->nullable();
            $table->enum('role', ['customer','admin','subadmin']);
            $table->integer('otp')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->string('password')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('shipping_address')->nullable();
            $table->boolean('automatic_location')->default(0);
            $table->boolean('status')->default(false)->comment('0 = disable, 1 = enable');
            $table->rememberToken();
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
};
