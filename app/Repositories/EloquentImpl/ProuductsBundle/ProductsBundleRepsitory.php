<?php


namespace App\Repositories\EloquentImpl\ProuductsBundle;


use App\Models\ProductsBundle;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\IProductsBundleRepository;
class ProductsBundleRepsitory extends BaseRepository implements IProductsBundleRepository
{
    public function __construct(ProductsBundle $model)
    {
        parent::__construct($model);
    }

}
