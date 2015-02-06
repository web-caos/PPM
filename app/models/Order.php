<?php

class Order extends Eloquent {

	protected $table = 'orders';

	public function items()
	{
		return $this->hasMany('Item', 'OrderId', 'OrderId');
	}

}
