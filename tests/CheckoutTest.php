<?php

use App\Checkout;
use App\ProductPrice;
use App\ProductDiscount;
use PHPUnit\Framework\TestCase;

final class CheckotTest extends TestCase {

    public function testTotalPriceOfGivenItemsWithMultipleDiscounts()
    {
        $pricingRules = [
            'A' => new ProductPrice(50, [new ProductDiscount(3, 20)]),
            'B' => new ProductPrice(30, [new ProductDiscount(2, 15)]),
            'C' => new ProductPrice(20, [new ProductDiscount(3, 10), new ProductDiscount(2, 2)]),
            'D' => new ProductPrice(15),
            'E' => new ProductPrice(5),
        ];

        $this->assertEquals((new Checkout('AABBBA', $pricingRules))->total(), 205);
        $this->assertEquals((new Checkout('AAAAAAA', $pricingRules))->total(), 310);
        $this->assertEquals((new Checkout('BB', $pricingRules))->total(), 45);
        $this->assertEquals((new Checkout('BBAAA', $pricingRules))->total(), 175);
        $this->assertEquals((new Checkout('CCBB', $pricingRules))->total(), 83);
        $this->assertEquals((new Checkout('AAACCC', $pricingRules))->total(), 180);
        $this->assertEquals((new Checkout('AABBCCC', $pricingRules))->total(), 195);
        $this->assertEquals((new Checkout('DDDDAAAABB', $pricingRules))->total(), 265);
        $this->assertEquals((new Checkout('E', $pricingRules))->total(), 5);
        $this->assertEquals((new Checkout('A', $pricingRules))->total(), 50);
        $this->assertEquals((new Checkout('AB', $pricingRules))->total(), 80);
        $this->assertEquals((new Checkout('CDBA', $pricingRules))->total(), 110);
        $this->assertEquals((new Checkout('AA', $pricingRules))->total(), 100);
        $this->assertEquals((new Checkout('AAA', $pricingRules))->total(), 130);
        $this->assertEquals((new Checkout('AAAA', $pricingRules))->total(), 180);
        $this->assertEquals((new Checkout('DDDCA', $pricingRules))->total(), 110);
        $this->assertEquals((new Checkout('AAAAE', $pricingRules))->total(), 185);
        $this->assertEquals((new Checkout('AAAB', $pricingRules))->total(), 160);
        $this->assertEquals((new Checkout('AAABB', $pricingRules))->total(), 175);
        $this->assertEquals((new Checkout('AAABBD', $pricingRules))->total(), 185);
        $this->assertEquals((new Checkout('DABABA', $pricingRules))->total(), 185);
        $this->assertEquals((new Checkout('DE', $pricingRules))->total(), 20);
        $this->assertEquals((new Checkout('ABCDE', $pricingRules))->total(), 115);

    }
}