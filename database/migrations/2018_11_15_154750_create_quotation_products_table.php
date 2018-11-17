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
            $table->string('provider');
            $table->integer('provider_atv_id');
            $table->integer('product_atv_id');
            $table->integer('age_from');
            $table->integer('age_to');
            $table->string('product_name');
            $table->string('terms_url');
            $table->integer('category');
            $table->float('bonification');
            $table->float('discount');
            $table->integer('type');
            $table->integer('recommended');
            $table->string('disease_insured_amt');
            $table->string('accident_insured_amt');
            $table->string('baggage_insured_amt');
            $table->boolean('is_deductible');
            $table->float('cost');
            $table->float('gross_cost');
            $table->float('orig_cost');
            $table->float('orig_gross_cost');
            $table->string('currency');
            $table->integer('currency_atv_id');
            $table->string('passengers_cost');
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
