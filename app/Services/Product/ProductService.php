<?php


namespace App\Services\Product;


use App\Repositories\Interfaces\IproductRepository;
use App\Services\BaseService;
use App\Services\Interfaces\IProductService;

class ProductService extends BaseService implements IProductService
{
    public function repository()
    {
        return IproductRepository::class;
    }

}
