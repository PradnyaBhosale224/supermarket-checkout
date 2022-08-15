<?php

namespace App;

class Checkout {
    private $pricingRules = [];
    private $itemsCounts  = [];
    private $itemsPrices  = [];

    //Calculates the total price of all items in this checkout
    public function __construct($itemsStr, $pricingRules)
    {
        $this->pricingRules = $pricingRules;
        $type_arr = array();
        $count_arr = array();
        $combine_arr =  array();
        foreach ($this->pricingRules as $type => $productPrice) 
        {
            array_push($type_arr, $type);
            $this->itemsCounts[$type]  = substr_count($itemsStr, $type);
            array_push($count_arr, $this->itemsCounts[$type]);
            $combine_arr = array_combine($type_arr, $count_arr);
            $this->itemsPrices[$type]  = $productPrice->priceFor($this->itemsCounts[$type],$combine_arr);
        }
    }

    //returns the total after special discount
    public function total()
    {
        return array_sum($this->itemsPrices);
    }
}