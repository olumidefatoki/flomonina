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
            $table->unsignedBigInteger('buyer_order_id');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('state_id');
            $table->string('truck_number');
            $table->string('driver_name');
            $table->string('driver_number');
            $table->integer('number_of_bags');
            $table->string('dispatch_location');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('buyer_order_id')->references('id')->on('buyer_order');
            $table->foreign('partner_id')->references('id')->on('partner');
            $table->foreign('state_id')->references('id')->on('state');
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
