<?php


namespace App\Rules;


use App\Services\Interfaces\IProductService;
use Illuminate\Contracts\Validation\Rule;

class ProductItemRule implements Rule
{
    private $productService;
    public $itemNotExists = '';

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function passes($attribute, $value)
    {
        $products = $this->productService->findAll(['name'])->toArray();
        $products = array_column($products, 'name');
        $cartItems = preg_split('/ +/', $value);
        foreach ($cartItems as $cartItem) {
            if (!in_array($cartItem, $products)) {
                $this->itemNotExists = $cartItem;
                return false;
            }
        }
        return true;
    }

    public function message()
    {
        return "This item {$this->itemNotExists} Not Available";
    }
}
