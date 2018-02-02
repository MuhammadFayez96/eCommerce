<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoughtDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bought_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bought_id')->unsigned();
            $table->foreign('bought_id')->references('id')->on('boughts')->onDelete('cascade');

            $table->double('amount');
            $table->double('cost');
            $table->string('product_type')->nullable();

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->integer('product_option_value_id')->unsigned();
            $table->foreign('product_option_value_id')->references('id')->on('product_option_values')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('bought_details');
    }
}
