<?php


namespace App\Services\Interfaces;


use App\Services\Interfaces\ICartService;

interface IShipping
{
    public function getCost(ICartService $cartService);

}
