<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('item_title');
            $table->integer('item_quantity');
            $table->float('item_unit_price');
            $table->string('approval_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_requests');
    }
}
