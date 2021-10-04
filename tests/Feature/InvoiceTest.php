<?php


namespace Feature;



use TestCase;
class InvoiceTest extends TestCase
{

    public function test_passing_invalid_currency_to_cart(){
        $response = $this->post('/api/cart', ['items'=>'T-shirt','currency'=>'cur']);
        $response->assertResponseStatus(422);
        $response->assertStringContainsString('currency' , $response->response->getContent());
    }
    public function test_passing_not_exists_item_to_cart(){
        $response = $this->post('/api/cart', ['items'=>'not-exits']);
        $response->assertResponseStatus(422);
        $response->assertStringContainsString('items' , $response->response->getContent());
    }
    public function test_valid_invoice_request(){
        $response = $this->post('/api/cart', ['items'=>'Jacket']);
        $response->assertResponseStatus(200);
    }

    public function test_the_store_default_currency(){
        $response = $this->post('/api/cart', ['items'=>'Jacket']);
        $response->assertResponseStatus(200);
        $response->assertStringContainsString('$' , $response->response->getContent());
    }
    public function test_total_invoice(){
        $response = $this->post('/api/cart', ['items'=>'Jacket']);
        $response->assertResponseStatus(200);
    }
    public function test_correct_invoice(){
        $response = $this->post('/api/cart', ['items'=>'Jacket']);
        $response->assertResponseStatus(200);
        $response->assertStringContainsString('Total' , $response->response->getContent());
    }
}
