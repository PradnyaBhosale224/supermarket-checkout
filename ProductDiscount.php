<?php

namespace App;

class ProductDiscount {
    private $productsCount;
    private $discount;

    public function __construct($productsCount, $discount)
    {
        $this->productsCount = $productsCount;
        $this->discount      = $discount;
    }

    //function for discount calculation 
    public function discountFor($count,$prod_array)
    {
        $sum = 0;
        $rem_count=$count;

        $closest = null;
        foreach ($prod_array as $item) {
              if ($closest === null || abs($rem_count - $closest) > abs($item - $count)) {
                 $closest = $item;
              }
        }
        
        $disc = $this->discountByCount($closest);
        
        if($rem_count >= $closest)
        {
          
           $sum += $disc * intval($rem_count / $closest);
           $rem_count = $rem_count - $closest;
        }
        else{
            $sum += 0;
            $rem_count += 0;
        }
        
        return array($sum,$rem_count);
    }

    //get product count
    public function getProductsCount()
    {
        return $this->productsCount;
    }

    //get discount by product count
    public function discountByCount($count)
    {
        $memoDiscount = null;

        if ($count >= $this->getProductsCount()) 
        {
            $memoDiscount = $this->discount;
        }
    
        return $memoDiscount;
    }
}