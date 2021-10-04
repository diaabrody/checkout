<?php


namespace App\Services;


use App\Repositories\IRepository;

class BaseService implements Iservice
{
    public $repository;

    /**
     * @param string[] $columns
     * @return mixed
     */
    public function findAll($columns = ['*'])
    {
        return $this->repository->findAll($columns);
    }

    /**
     * @param $field
     * @param null $value
     * @param string[] $columns
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        return $this->repository->findByField($field, $value, $columns);
    }

    /**
     * @param $id
     * @param string[] $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * @return |null|IRepository
     */
    public function repository()
    {
        return null;
    }

    /**
     * @param IRepository $repository
     */
    public function setRepository(IRepository $repository)
    {
        $this->repository = $repository;
    }
}
