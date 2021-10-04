<?php


namespace App\Repositories\EloquentImpl\Weight;


use App\Models\WeightClass;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\IweightClassRepository;

class weightClassRepository extends BaseRepository implements IweightClassRepository
{
    public function __construct(WeightClass $model)
    {
        parent::__construct($model);
    }

}
