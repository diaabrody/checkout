<?php


namespace App\Services\Offer;


use App\Models\Item;
use App\Repositories\Interfaces\IOfferRepository;
use App\Repositories\Interfaces\IProductsBundleRepository;
use App\Services\BaseService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IOfferService;

class OfferService extends BaseService implements IOfferService
{
    /**
     * @var IProductsBundleRepository
     */
    private $productsBundleRepository;

    public function __construct(IProductsBundleRepository $productsBundleRepository)
    {
        $this->productsBundleRepository = $productsBundleRepository;
    }

    /**
     * @return string|null
     */
    public function repository()
    {
        return IOfferRepository::class;
    }


    /**
     * @param ICartService $cartService
     * @param Item $item
     */
    public function calculateItemOffer(ICartService $cartService, Item $item)
    {
        if (isset($item->offer) && $item->quantity >= $item->offer->quantity) {
            if (!$item->offer->related_product || empty($item->offer->related_product)) {
                $cartService->offers[$item->name] =
                    [
                        'price' => $this->applyOffer($item->offer->discount, $item->total()),
                        'discount' => $item->offer->discount
                    ];
            } else {
                if (in_array($item->offer->related_product, array_keys($cartService->items))) {

                    $item = $cartService->items[$item->offer->related_product];
                    $cartService->offers[$item->name] =
                        [
                            'price' => $this->applyOffer($item->offer->discount, $item->total()),
                            'discount' => $item->offer->discount
                        ];
                }
            }
        }
        $this->calculateItemsBundleOffers($cartService, $item);
    }

    private function calculateItemsBundleOffers(ICartService $cartService, Item $item)
    {
        // find the products bundle offers
        if (isset($item->bundle_id) && !isset($cartService->cartItemsBundles[$item->bundle_id])) {
            $bundle = $item->bundle->bundle;
            $bundleOffer = $this->repository->findByField('bundle_id', $item->bundle_id)->first();
            if ($bundleOffer
                && $this->in_array_all($bundle, array_keys($cartService->items))
                && in_array($bundleOffer->related_product, array_keys($cartService->items))) {
                $item = $cartService->items[$bundleOffer->related_product];
                $cartService->offers[$bundleOffer->related_product] =
                    [
                        'price' => $this->applyOffer($bundleOffer->discount, $item->total()),
                        'discount' => $bundleOffer->discount
                    ];
            }
        }
    }

    public function applyOffer($discount, $price)
    {
        return $price * $discount / 100;
    }

    function in_array_all($needles, $haystack)
    {
        return empty(array_diff($needles, $haystack));
    }


}
