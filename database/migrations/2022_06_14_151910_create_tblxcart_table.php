<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblxcartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblxcart', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ordernum', 45)->default('');
            $table->integer('itemid')->default('0');
            $table->integer('uomid')->default('0');
            $table->double('qty', 10, 4)->default('0');
            $table->double('amt', 10, 4)->default('0');
            $table->double('total', 10, 4)->default('0');
            $table->unsignedInteger('userid');
            $table->foreign('userid')->references('userid')->on('tblusers');
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
        Schema::dropIfExists('tblxcart');
    }
}
