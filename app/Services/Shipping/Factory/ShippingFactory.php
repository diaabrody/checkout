<?php


namespace App\Services\Shipping\Factory;


use App\Services\Interfaces\IShipping;
use App\Services\Shipping\CustomShippingService;

class ShippingFactory
{

    /**
     * @param $shippingType
     * @return IShipping
     */
    public static function getShipping($shippingType): IShipping
    {
        switch ($shippingType) {
            case 'custom':
                return app()->make(CustomShippingService::class);
                break;
            default:
                return app()->make(CustomShippingService::class);
        }
    }

}
