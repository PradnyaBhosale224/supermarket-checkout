<?php

namespace App;

class ProductPrice {
    private $singlePrice;
    private $discounts;

    public function __construct($singlePrice, $discounts = [])
    {
        $this->singlePrice = $singlePrice;

        $this->discounts =
            $discounts instanceof ProductDiscount ?
            [$discounts] : $discounts;  
    }

    //calculation for product price with discount
    public function priceFor($count,$combine_arr)
    {
        $discount = $this->_getDiscountByCount($count);
        $price    = $count * $this->singlePrice;
        
        $flag1 = 0;
        $flag2 = 0;
        $final = 0;
        $countofA = 0;
        $countofD = 0;

        //calculation of Product 'D', if it is purchased with product 'A' 
        if(count($combine_arr) == 5)
        {
            foreach($combine_arr as $key => $value)
            {
            
                if($key == 'D' && $value != 0)
                {
                    $flag1 = 1;
                    $countofD = $value;         
                }
                if($key == 'A' && $value != 0)
                {
                    $flag2 = 1;
                    $countofA = $value;
                }    
            }
             
            if($flag1 ==  1 && $flag2 == 1)
            {
                if($countofD >= $countofA)
                {
                    $final = 5 * $countofA;
                }
                if($countofD < $countofA)
                {
                    $final = 5 * $countofD;
                }
                
            } 
            else{
                $final = 0;
            }
        }
        
        $prod_array = array();
        $disc_array = array();
        

        if ($discount)
        {
            
            foreach($discount as $disc)
            {
                array_push($prod_array, $disc->getProductsCount());
                array_push($disc_array, $disc);
            }
            $rem_count = $count;
            
            foreach($disc_array as $d)
            {
            
                $closest = null;
                foreach ($prod_array as $item) {
                      if ($closest === null || abs($rem_count - $closest) > abs($item - $count)) {
                         $closest = $item;
                      }
                }
                
                if($rem_count >= $closest)
                {
                    $disc_arr = $d->discountFor($count,$prod_array);
                    $price -= $disc_arr[0];
                    $rem_count = $disc_arr[1];
                }
                else
                {
                    $disc_arr = $d->discountFor($rem_count,$prod_array);
                    $price -= $disc_arr[0];
                    $rem_count = $disc_arr[1];
                }
            }
        } 

        return $price - $final;
    }

    //get discount by product count
    protected function _getDiscountByCount($count)
    {
        $memoDiscount = array();
        foreach ($this->discounts as $discount) 
        {
            
            if ($count >= $discount->getProductsCount()) 
            {
                array_push($memoDiscount,$discount);
            }
        }
        return $memoDiscount;
    }
}