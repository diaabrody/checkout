<?php


namespace App\Repositories;


interface IRepository
{
    public function findAll($columns);

    public function findByField($field, $value = null, $columns = [['*']]);
}
