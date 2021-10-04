<?php


namespace App\Providers;

use App\Models\ShippingDiscount;
use App\Repositories\EloquentImpl\Currency\CurrencyRepository;
use App\Repositories\EloquentImpl\Item\ItemRepository;
use App\Repositories\EloquentImpl\Offer\OfferRepository;
use App\Repositories\EloquentImpl\Product\ProductRepository;
use App\Repositories\EloquentImpl\ShippingDiscount\ShippingDiscountRepository;
use App\Repositories\EloquentImpl\Weight\weightClassRepository;
use App\Services\Cart\CartService;
use App\Services\Currency\CurrencyService;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\ICurrencyService;
use App\Services\Interfaces\IOfferService;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\IShippingDiscountService;
use App\Services\Interfaces\IWeightClassService;
use App\Services\Offer\OfferService;
use App\Services\Product\ProductService;
use App\Services\ShippingDiscount\ShippingDiscountService;
use App\Services\Weight\WeightClassService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    private $map = [
        ICartService::class => [
            'service' => CartService::class,
            'repository' => ItemRepository::class
        ],
        IProductService::class => [
            'service' => ProductService::class,
            'repository' => ProductRepository::class
        ],
        IOfferService::class => [
            'service' => OfferService::class,
            'repository' => OfferRepository::class
        ],
        ICurrencyService::class => [
            'service' => CurrencyService::class,
            'repository' => CurrencyRepository::class
        ],
        IWeightClassService::class => [
            'service' => WeightClassService::class,
            'repository' => weightClassRepository::class
        ],
        IShippingDiscountService::class => [
            'service' => ShippingDiscountService::class,
            'repository' => ShippingDiscountRepository::class
        ]
    ];

    public function register()
    {
        parent::register();
    }

    public function boot()
    {
        foreach ($this->map as $abstract => $class) {
            $this->app->bind($abstract, function ($app) use ($class) {
                $serviceInstance = $app->make($class['service']);
                if ($serviceInstance->repository() && $class['repository']) {
                    $serviceInstance->setRepository($app->make($class['repository']));
                }
                return $serviceInstance;
            });
        }
    }

}
