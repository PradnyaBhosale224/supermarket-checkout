<?php

namespace App;

class ProductDiscount {
    private $productsCount;
    private $discount;

    //assign product count and discount
    public function __construct($productsCount, $discount)
    {
        $this->productsCount = $productsCount;
        $this->discount      = $discount;
    }

    //calculate discount
    public function discountFor($count, $closeVal)
    {
        echo " count++++++++".$count;
        echo " discountFor==== ".$closeVal;
        echo " product count=== ".$this->productsCount;
        echo " disc PRICE ==== ".$closeVal * intval($count / $this->productsCount);
        return $closeVal * intval($count / $this->productsCount);

    }

    //get the product count
    public function getProductsCount()
    {
        return $this->productsCount;
    }
}