<?php

namespace Gloversure\Store;

/**
 * Holds information about the users' current basket
 * Calculates the total for the basket
 * 
 * @package \Gloversure\Store
 */
class Basket
{
    /**
     * @var float                 $total    total price of the basket
     * @var Array<Basket\Product> $products all products currently in the basket
     */
    public float $total = 0;
    private Array $products = [];

    /**
     * Adds a product to the basket
     * Should update the 
     *
     * @param \Gloversure\Store\Product $product  product to add to the basket
     * @param int                       $quantity number of products to add to the basket
     * 
     * @return void
     */
    public function addItems(Product $product, int $quantity = 0): void
    {
        if (isset($this->products[$product->sku]))
            $this->products[$product->sku]->quantity += $quantity;
        else {
            $newProduct = new Basket\Product(
                $product,
                $quantity,
            );

            $this->products[$product->sku] = $newProduct;
        }

        $this->calculateTotal();
    }

    /**
     * Calculates the total for the basket
     * 
     * @return void
     */
    protected function calculateTotal(): void
    {
        $this->total = 0;
        /** @var Basket\Product $product */
        foreach ($this->products as $product) {
            $this->total += $product->product->price * $product->quantity;
        }
    }
}