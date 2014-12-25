<?php

class Product extends Eloquent {

    protected $table = 'products';
    protected $primaryKey = 'Code';

    public function Total(){
        return $this->hasOne('Product2', 'Code', 'Code');
    }

}