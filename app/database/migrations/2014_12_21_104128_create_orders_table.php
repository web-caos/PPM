<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function($table)
		{
			$table->increments('id');
			$table->string('AmazonOrderId');
			$table->string('PurchaseDate');
			$table->string('OrderStatus');
			$table->longText('ShippingAddress');
			$table->string('OrderTotal');
			$table->string('BuyerEmail');
			$table->string('InvoiceRequest')->default('No');
			$table->longText('InvoiceDetails');
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
		Schema::drop('orders');
	}

}
