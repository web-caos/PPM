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
            $table->longtext('DescriptionHTML');
            $table->string('ProducerName');
            $table->string('SupplierProductCode');
            $table->decimal('GrossPrice1', 15, 2);
            $table->decimal('GrossPrice2', 15, 2);
            $table->decimal('GrossPrice3', 15, 2);
            $table->decimal('GrossPrice4', 15, 2);
            $table->integer('NetWeight');
            $table->integer('NetSizeX');
            $table->integer('NetSizeY');
            $table->integer('NetSizeZ');
            $table->integer('AvailableQty');
            $table->decimal('Shipping', 15, 2);
            $table->string('ShopStatus');
            $table->string('MarketplacesStatus');
            $table->string('AmazonStatus');
            $table->string('eBayStatus');
            $table->string('ePriceStatus');
            $table->string('PixManiaStatus');
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
