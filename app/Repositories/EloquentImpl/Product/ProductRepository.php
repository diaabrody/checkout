<?php


namespace App\Repositories\EloquentImpl\Product;


use App\Models\Product;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\IproductRepository;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository implements IproductRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

}
