<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aggregator', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address', 255);
            $table->string('contact_person_name', 50);
            $table->string('contact_person_email', 255)->unique()->nullable();
            $table->string('contact_person_phone_number', 11)->unique();
            $table->unsignedBigInteger('bank_id');
            $table->string('account_number', 11)->unique()->nullable();
            $table->string('account_name', 255);
            $table->string('img_path')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('state_id')->references('id')->on('state');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('partner');
    }
}
