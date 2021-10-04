<?php


namespace Unit;
use App\Services\Cart\CartService;
use App\Services\Interfaces\ICartService;
use TestCase;

class InvoiceUnitTest extends TestCase
{
    private $cartService;
    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function test_create_items_function_to_creat_items(){
        $cartService = app()->make(ICartService::class);
        $cartService->createItems('Jacket');
        $this->assertArrayHasKey('Jacket' , $cartService->items);
    }

    public function test_invoice_currency_unit(){
        $cartService = app()->make(ICartService::class);
        $cartService->createCart(['currency'=>'USD' , 'items'=>'Jacket']);
        $this->assertStringContainsStringIgnoringCase("$" , $cartService->checkout());

        $cartService->createCart(['currency'=>'EGP' , 'items'=>'Jacket']);
        $this->assertStringContainsStringIgnoringCase("E£" , $cartService->checkout());
    }

}
