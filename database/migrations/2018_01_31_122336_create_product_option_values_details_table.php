<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionValuesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_option_values_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_value_id')->unsigned();
            $table->foreign('option_value_id')->references('id')->on('option_values')->onDelete('cascade');

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
        Schema::dropIfExists('product_option_values_details');
    }
}
