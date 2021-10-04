<?php


namespace App\Repositories\EloquentImpl\ShippingDiscount;


use App\Models\ShippingDiscount;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\IShippingDiscountRepository;

class ShippingDiscountRepository extends BaseRepository implements IShippingDiscountRepository
{
    public function __construct(ShippingDiscount $model)
    {
        parent::__construct($model);
    }

}
