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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('phone_company')->nullable();
            $table->string('phone_model')->nullable();
            $table->string('expected_rent')->nullable();
            $table->string('preferred_location')->nullable();
            $table->string('required_property_details')->nullable();
            $table->dateTime('date_of_journey')->nullable();
            $table->time('time_of_journey')->nullable();
            $table->string('approximate_load')->nullable();
            $table->string('estimated_work_hours')->nullable();
            $table->string('no_of_passengers')->nullable();
            $table->string('estimated_distance')->nullable();
            $table->string('total_orchard_area')->nullable();
            $table->string('age_of_orchard')->nullable();
            $table->string('type_of_fruit_plant')->nullable();
            $table->string('total_estimated_weight')->nullable();
            $table->string('expected_demanded_total_cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
