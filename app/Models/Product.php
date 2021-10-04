<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    protected $with = ['offer'];

    public function offer(){
        return $this->hasOne(Offer::class ,'product_name','name');
    }
    public function weightClass(){
        return $this->hasOne(WeightClass::class , 'id' ,'weight_class_id');
    }
    public function bundle(){
        return $this->hasOne(ProductsBundle::class , 'id' ,'bundle_id');
    }

}
