<?php


namespace App\Repositories\EloquentImpl\Currency;


use App\Models\Currency;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\ICurrencyRepository;

class CurrencyRepository extends BaseRepository implements ICurrencyRepository
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

}
