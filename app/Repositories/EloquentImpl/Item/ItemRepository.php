<?php


namespace App\Repositories\EloquentImpl\Item;


use App\Models\Item;
use App\Repositories\EloquentImpl\BaseRepository;
use App\Repositories\Interfaces\IItemRepository;

class ItemRepository extends BaseRepository implements IItemRepository
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }

}
