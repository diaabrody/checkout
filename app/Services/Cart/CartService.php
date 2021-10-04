<?php


namespace App\Services\Cart;


use App\Repositories\Interfaces\IItemRepository;
use App\Services\BaseService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\ICurrencyService;
use App\Services\Interfaces\IOfferService;
use App\Services\Interfaces\IShipping;
use App\Services\Interfaces\IShippingDiscountService;
use App\Services\Shipping\Factory\ShippingFactory;

class CartService extends BaseService implements ICartService
{
    public $items;
    public $subTotal = 0;
    public $offers = [];
    public $total = 0;
    public $cartTax = 0;
    public $cartCurrency = 'USD';
    public $items_count = 0;
    private $offerService;
    private $currencyService;
    private $shippingDiscountService;
    public $shipping;
    public $cartShippingCost;
    public $cartShippingDiscount = [];
    public $cartItemsBundles = [];
    const DEFAULT_CURRENCY = 'USD';
    const TAX_PERCENT = 14;
    const DEFAULT_UNIT = 'KG';


    public function __construct(
        IOfferService $offerService,
        ICurrencyService $currencyService,
        IShippingDiscountService $shippingDiscountService
    )
    {
        $this->offerService = $offerService;
        $this->currencyService = $currencyService->load();
        $this->shippingDiscountService = $shippingDiscountService;
        $shippingDiscountService->setCartRepository($this);
        $this->shipping = ShippingFactory::getShipping('custom');
    }

    /**
     * @return string|null
     */
    public function repository()
    {
        return IItemRepository::class;
    }

    /**
     * @param array $data
     */
    public function createCart($data)
    {
        $items = $data["items"];
        $this->cartCurrency = (isset($data["currency"])) ? $data["currency"] : self::DEFAULT_CURRENCY;
        $this->createItems($items);
    }

    /**
     * @param $items
     */
    public function createItems($items)
    {
        $cartItems = preg_split('/ +/', $items);
        // get every item count  ['jacket' => 2]
        $cartItems = array_count_values($cartItems);
        // transforming each item to item Model
        foreach ($cartItems as $cartItem => $quantity) {
            $item = $this->repository->findByField('name', $cartItem)->first();
            if ($item) {
                $item->quantity = $quantity;
                $this->items[$cartItem] = $item;
                $this->items_count += $quantity;
            }
        }
    }

    public function checkout()
    {
        // collect totals
        foreach ($this->items as $item) {
            $this->subTotal += $item->total();
            $this->offerService->calculateItemOffer($this, $item);
        }
        $this->total = $this->subTotal;
        $this->cartTax = self::TAX_PERCENT * $this->subTotal / 100;
        $this->total += $this->cartTax;
        $this->cartShippingCost = $this->getShippingCost();
        $this->shippingDiscountService->applyShippingDiscountToCart();
        $this->total += $this->cartShippingCost;
        $this->convertTotalsCurrencyToCurrency();
        return $this->createInvoice();
    }

    public function createInvoice()
    {
        $currencySymbol = $this->currencyService->getSymbol($this->cartCurrency);
        $invoicePresenter = "SubTotal: $this->subTotal {$currencySymbol} \n";
        $invoicePresenter .= "Shipping:{$this->cartShippingCost} {$currencySymbol}  \n";
        $invoicePresenter .= "VAT:{$this->cartTax} {$currencySymbol}  \n";
        if (count($this->offers) > 0) {
            $invoicePresenter .= "Discounts:\n";
            foreach ($this->offers as $productName => $value) {
                $itemDiscount = $this->currencyService
                    ->convert($value['price'], self::DEFAULT_CURRENCY, $this->cartCurrency);

                $invoicePresenter .= "{$value['discount']}% off $productName:-{$itemDiscount}{$currencySymbol}\n";
                $this->total -= $itemDiscount;
            }
        }
        // apply shipping Offer if exits
        if (count($this->cartShippingDiscount) > 0) {
            $fixedMaximumDiscount = $this->cartShippingDiscount['fixedMaximumDiscount'];
            $cartDiscount = $this->cartShippingDiscount['cartDiscount'];
            $invoicePresenter .= "{$fixedMaximumDiscount}$currencySymbol off Shipping - $cartDiscount {$currencySymbol} \n";
        }


        $invoicePresenter .= "Total: {$this->total} $currencySymbol";

        return $invoicePresenter;
    }

    public function convertTotalsCurrencyToCurrency()
    {
        $this->subTotal = $this->currencyService
            ->convert($this->subTotal, self::DEFAULT_CURRENCY, $this->cartCurrency);
        $this->cartTax = $this->currencyService
            ->convert($this->cartTax, self::DEFAULT_CURRENCY, $this->cartCurrency);
        $this->total = $this->currencyService
            ->convert($this->total, self::DEFAULT_CURRENCY, $this->cartCurrency);
        $this->cartShippingCost = $this->currencyService
            ->convert($this->cartShippingCost, self::DEFAULT_CURRENCY, $this->cartCurrency);

        if (isset($this->cartShippingDiscount['fixedMaximumDiscount']) &&
            isset($this->cartShippingDiscount['cartDiscount'])) {
            $fixedMaximumDiscount = $this->cartShippingDiscount['fixedMaximumDiscount'];
            $cartDiscount = $this->cartShippingDiscount['cartDiscount'];
            $this->cartShippingDiscount['fixedMaximumDiscount'] = $this->currencyService
                ->convert($fixedMaximumDiscount, self::DEFAULT_CURRENCY, $this->cartCurrency);
            $this->cartShippingDiscount['cartDiscount'] = $this->currencyService
                ->convert($cartDiscount, self::DEFAULT_CURRENCY, $this->cartCurrency);
        }
    }

    /**
     * @return mixed
     */
    public function getShippingCost()
    {
        return $this->shipping->getCost($this);
    }

    /**
     * @param IShipping $IShipping
     */
    public function setShipping(IShipping $IShipping)
    {
        $this->shipping = $IShipping;
    }

    /**
     * @return int
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @return int
     */
    public function getItemsCount()
    {
        return $this->items_count;
    }

    public function getShippingDiscount()
    {
        return $this->cartShippingDiscount;
    }
}
