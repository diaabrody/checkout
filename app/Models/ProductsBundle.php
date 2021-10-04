<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductsBundle extends Model
{
    protected $table ='products_bundle';
    protected $casts = [
        'bundle' => 'array'
    ];

}
