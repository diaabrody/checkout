<?php


namespace App\Services\ShippingDiscount;


use App\Repositories\Interfaces\ICartRepository;
use App\Repositories\Interfaces\IShippingDiscountRepository;
use App\Services\BaseService;
use App\Services\Cart\CartService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IShippingDiscountService;

class ShippingDiscountService extends BaseService implements IShippingDiscountService
{

    /**
     * @var CartService
     */
    private $cartService;


    /**
     * @return string|null
     */
    public function repository()
    {
        return IShippingDiscountRepository::class;
    }


    /**
     * @param $shippingCode
     * @return mixed
     */
    public function getShippingDiscount($shippingCode)
    {
        return
            $this->repository
                ->findByField('shipping_code', $shippingCode)
                ->first();
    }

    public function applyShippingDiscountToCart()
    {
        $shippingCode = get_class($this->cartService->shipping)::SHIPPING_CODE;
        $shippingCost = $this->cartService->cartShippingCost;
        $itemCounts = $this->cartService->items_count;
        $discountObj = $this->getShippingDiscount($shippingCode);
        if ($discountObj && $itemCounts >= $discountObj->items_count) {
            if ($discountObj->fixed_discount >= $shippingCost)
                $discount = $shippingCost;
            else
                $discount = $discountObj->fixed_discount;
            $this->cartService->total -= $discount;
            $this->cartService->total = max($this->cartService->total , 0);
            $this->cartService->cartShippingDiscount = [
                'fixedMaximumDiscount' => $discountObj->fixed_discount,
                'cartDiscount' => $discount
            ];
        }
    }

    public function setCartRepository(ICartService $CartService)
    {
        $this->cartService = $CartService;
    }

}
