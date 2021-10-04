<?php


namespace App\Repositories\EloquentImpl\Offer;


use App\Models\Offer;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\IOfferRepository;

class OfferRepository extends BaseRepository implements IOfferRepository
{
    public function __construct(Offer $model)
    {
        parent::__construct($model);
    }

}
