<?php


namespace App\Services\Shipping;


use App\Services\BaseService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IShipping;
use App\Services\Interfaces\IShippingDiscountService;
use App\Services\Interfaces\IWeightClassService;

class CustomShippingService extends BaseService implements IShipping
{
    const RATES = [
        'weight' => [
            'per' => 100,
            'unit' => "G"
        ],
        'rates' => [
            'US' => [
                'country' => 'US',
                'rate' => 2
            ],
            'UK' => [
                'country' => 'UK',
                'rate' => 3
            ],
            'CN' => [
                'country' => 'CN',
                'rate' => 2
            ],
        ]
    ];
    const SHIPPING_CODE = 'CUSTOM';
    private $cartService;

    private $weightClassService;

    private $shippingDiscountService;

    public function __construct(IWeightClassService $weightClassService, IShippingDiscountService $shippingDiscountService)
    {
        $this->weightClassService = $weightClassService->load();
        $this->shippingDiscountService = $shippingDiscountService;
    }

    public function getCost(ICartService $cartService)
    {
        $this->cartService = $cartService;
        $cost = 0;
        $total = 0;
        foreach ($cartService->items as $item) {
            if (isset(self::RATES['rates'][$item->shipped_from])) {
                $itemWeight = $item->weight();
                $itemUnit = $item->weightClass->unit;
                $shippingUnit = self::RATES['weight']['unit'];
                $shippingPer = self::RATES['weight']['per'];
                $itemWeight = $this->weightClassService->convert($itemWeight, $itemUnit, $shippingUnit);
                $cost = $itemWeight / $shippingPer * self::RATES['rates'][$item->shipped_from]['rate'];
                $total += $cost;
            }
        }
        return $total;
    }

    private function getShippingDiscount()
    {
        $result = 0;
        $discount = $this->shippingDiscountService->getShippingDiscount(self::SHIPPING_CODE);
        $itemCount = $this->cartService->getItemsCount();
        if ($discount && $itemCount >= $discount->items_count) {
            $result = $discount->fixed_discount;
        }
        return $result;
    }
}
