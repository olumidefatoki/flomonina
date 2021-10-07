<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dispatch_id');
            $table->decimal('accepted_quantity', 13, 2);
            $table->decimal('aggregator_price', 13, 2);
            $table->decimal('discounted_price', 13, 2);
            $table->decimal('trade_price', 13, 2);
            $table->decimal('margin', 13, 2);
            $table->integer('no_of_bags_rejected');
            $table->string('way_ticket');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('dispatch_id')->references('id')->on('dispatch');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status');
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
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
        Schema::dropIfExists('buyer_delivery');
    }
}
