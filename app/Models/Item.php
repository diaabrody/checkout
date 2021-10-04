<?php


namespace App\Models;


class Item extends Product
{
    protected $table = 'products';
    public $quantity = 1;

    public function total()
    {
        return $this->price * $this->quantity;
    }

    public function weight()
    {
        return $this->weight * $this->quantity;
    }


}
