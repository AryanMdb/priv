<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('status')->default(true)->comment('0 = status disable, 1 = status enable');
            $table->integer('order')->default(0);
            $table->string('min_value')->nullable();
            $table->string('max_value')->nullable();
            $table->string('delivery_charge')->nullable();
            $table->string('min_distance_value')->nullable();
            $table->string('max_distance_value')->nullable();
            $table->string('distance_charge')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
