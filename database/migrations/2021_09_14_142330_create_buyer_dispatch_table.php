<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerDispatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_id');
            $table->unsignedBigInteger('aggregator_id');
            $table->unsignedBigInteger('pickup_state_id');
            $table->unsignedBigInteger('destination_state_id');
            $table->dateTime('dispatch_time', 0);
            $table->unsignedBigInteger('commodity_id');
            $table->string('truck_number');
            $table->string('driver_name');
            $table->string('driver_number');
            $table->integer('number_of_bags');
            $table->string('logistics_company')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->dateTime('estimated_arrivial_time', 0);
            $table->foreign('aggregator_id')->references('id')->on('aggregator');
            $table->foreign('trade_id')->references('id')->on('trade');
            $table->foreign('pickup_state_id')->references('id')->on('state');
            $table->foreign('destination_state_id')->references('id')->on('state');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status');
            $table->timestamps();
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_dispatch');
    }
}
