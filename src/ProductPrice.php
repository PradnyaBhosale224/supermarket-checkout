<?php

namespace App;

class ProductPrice {
    private $singlePrice;
    private $discounts;

    //Price & discount of an single item, __construct function is created to initialise the object properties
    public function __construct($singlePrice, $discounts = [])
    {
        $this->singlePrice = $singlePrice;
        // echo "<br>";
        // print_r($this->singlePrice);
        $this->discounts =
            $discounts instanceof ProductDiscount ?
            [$discounts] : $discounts;
        // echo "<br>";
        // print_r($this->discounts);    
    }

    //final Price of an item after discount
    public function priceFor($count)
    {
        $discount = $this->_getDiscountByCount($count);
        $price    = $count * $this->singlePrice;
        //  echo "discount priceFor ===";
        // print_r($discount);

        if ($discount)
            // print_r(count($discount));
            
            $closest = null;
            foreach($discount as $disc)
            {
                echo '<pre>'; var_dump($disc);
                // echo "DIsc|||||||||| === "; print_r($disc);
                $price -= $disc->discountFor($count);
                // echo "price====".$price;
            }
        return $price;
    }

    //apply discount according to item count in a cart
    protected function _getDiscountByCount($count)
    {
        $memoDiscount = array();
        // echo "count===".$count;
        // print_r($this->discounts);
        foreach ($this->discounts as $discount) 
        {

            if ($count >= $discount->getProductsCount()) {
                array_push($memoDiscount,$discount);
                //  echo "discount priceFor ===";
                // print_r($memoDiscount);
            }
        }
         // echo "<br>memoDiscount===";
         //    print_r($memoDiscount);
        return $memoDiscount;
    }
}
