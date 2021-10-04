<?php


namespace App\Services\Interfaces;


interface ICurrencyService
{
    public function convert($value, $from, $to);
}
