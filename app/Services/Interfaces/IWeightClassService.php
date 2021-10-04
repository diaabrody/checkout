<?php


namespace App\Services\Interfaces;


interface IWeightClassService
{
    public function convert($value, $from, $to);

}
