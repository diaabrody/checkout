<?php


namespace App\Repositories\EloquentImpl;


use App\Repositories\IRepository;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IRepository
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param string[] $columns
     * @return mixed
     */
    public function findAll($columns = ['*'])
    {
        return $this->model->get($columns);
    }


    /**
     * @param $field
     * @param null $value
     * @param string[] $columns
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*']){
        return $this->model->where($field, '=', $value)->get($columns);
    }

    /**
     * @param $id
     * @param string[] $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']){
       return $this->model->find($id, $columns);
    }
}
