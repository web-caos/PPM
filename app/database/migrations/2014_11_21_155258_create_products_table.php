<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('products', function($table)
        {
            $table->string('Code')->primary();
            $table->string('BarCode');
            $table->string('Description');
            $table->string('ProducerName');
            $table->string('SupplierProductCode');
            $table->decimal('GrossPrice4', 15, 2);
            $table->integer('AvailableQty');
            $table->decimal('Shipping', 15, 2);
            $table->string('NextAction');
            $table->string('AmazonStatus');
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
        Schema::drop('products');
	}

}
