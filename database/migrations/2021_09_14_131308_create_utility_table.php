<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('state_code');
            $table->charset = 'utf8';   
            $table->collation = 'utf8_general_ci';
        });

        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->charset = 'utf8';   
            $table->collation = 'utf8_general_ci';
        });
        Schema::create('commodity', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->charset = 'utf8';   
            $table->collation = 'utf8_general_ci';
        });
        Schema::create('lga', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('state');
            $table->charset = 'utf8';   
            $table->collation = 'utf8_general_ci';
        });
        Schema::create('bank', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
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
        Schema::dropIfExists('utility');
    }
}
