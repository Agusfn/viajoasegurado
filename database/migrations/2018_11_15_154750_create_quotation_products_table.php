<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('quotation_id');
            $table->string('img_url');
            $table->string('provider_name');
            $table->integer('provider_atv_id');
            $table->integer('product_atv_id');
            $table->string('product_name');
            $table->string('terms_url');
            $table->string('disease_insured_amt');
            $table->string('accident_insured_amt');
            $table->string('baggage_insured_amt');
            $table->text('coverage_details_json')->nullable();
            $table->float('cost');
            $table->float('gross_cost');
            $table->string('cost_currency_code');
            $table->float('price');
            $table->float('gross_price');
            $table->string('price_currency_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_products');
    }
}
