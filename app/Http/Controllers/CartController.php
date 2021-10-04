<?php


namespace App\Http\Controllers;

use App\Repositories\Interfaces\IproductRepository;
use App\Rules\ProductItemRule;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IProductService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(ICartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createCart(Request $request, IProductService $productService)
    {
        $validatedData = $this->validate($request, [
            'currency' => 'string | exists:currency,code',
            'items' => ['required', 'string', new ProductItemRule($productService)]
        ]);
        $this->cartService->createCart($validatedData);
        return $this->cartService->checkout();
    }

}
