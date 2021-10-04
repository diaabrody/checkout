<?php


namespace App\Services;


interface Iservice
{
    public function findAll($columns);
    public function findByField($field, $value,$columns);

}
