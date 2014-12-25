<?php

class Order extends Eloquent {

	protected $table = 'orders';
	//protected $primaryKey = 'AmazonOrderId';

	public function items()
	{
		return $this->hasMany('Item', 'AmazonOrderId', 'AmazonOrderId');
	}

}
