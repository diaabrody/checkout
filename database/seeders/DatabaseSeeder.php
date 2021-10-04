<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductsBundle;
use App\Models\ShippingDiscount;
use App\Models\WeightClass;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $weights = [
            [
                'title' => 'KG',
                'unit' => 'KG',
                'value' => 1
            ],
            [
                'title' => 'G',
                'unit' => 'G',
                'value' => 1000
            ],
        ];

        $currencies = [
            [
                'title' => 'Egyptian pound',
                'code' => 'EGP',
                'symbol' => 'E£' ,
                'value' => 15
            ],
            [
                'title' => 'Dollar',
                'code' => 'USD',
                'symbol' => '$' ,
                'value' => 1
            ],
        ];
        $shippingDiscounts = [
            'items_count' => 2 ,
            'fixed_discount' => 10 ,
            'shipping_code' => 'CUSTOM'
        ];

        $products = [
            [
                'name' => 'T-shirt',
                'price' => 30.99,
                'weight' => 0.2,
                'shipped_from' => 'US',
                'weight_class_id' =>1 ,
                'bundle_id'=>1
            ],
            [
                'name' => 'Blouse',
                'price' => 10.99,
                'weight' => 0.3 ,
                'shipped_from' => 'UK',
                'weight_class_id' =>1,
                'bundle_id'=>1
            ],
            [
                'name' => 'Pants',
                'price' => 64.99,
                'weight' => 0.9 ,
                'shipped_from' => 'UK',
                'weight_class_id' =>1 ,
                'bundle_id'=>null
            ],
            [
                'name' => 'Sweatpants',
                'price' => 84.99,
                'weight' => 1.1 ,
                'shipped_from' => 'CN',
                'weight_class_id' =>1 ,
                'bundle_id'=>null
            ],
            [
                'name' => 'Jacket',
                'price' => 199.99,
                'weight' => 2.2 ,
                'shipped_from' => 'US',
                'weight_class_id' =>1 ,
                'bundle_id'=>null
            ],
            [
                'name' => 'Shoes',
                'price' => 79.99,
                'weight' => 1.3 ,
                'shipped_from' => 'CN',
                'weight_class_id' =>1 ,
                'bundle_id'=>null
            ]
        ];
        $products_bundle = [
          'bundle' => ['T-shirt' , 'Blouse']
        ];

        $offers = [
            [
                'product_name' => 'Shoes',
                'quantity' => 1,
                'related_product' => null ,
                'discount' => 10
            ],
            [
                'product_name' => 'T-shirt',
                'quantity' => 2,
                'related_product' => 'Jacket' ,
                'discount' =>50
            ],
            [
                'product_name' => 'Blouse',
                'quantity' => 2,
                'related_product' => 'Jacket' ,
                'discount' =>50
            ],

            [
                'related_product' => 'Jacket' ,
                'bundle_id' => 1,
                'discount' =>50
            ],

        ];
        WeightClass::insert($weights);
        Currency::insert($currencies);
        ProductsBundle::create($products_bundle);
        ShippingDiscount::create($shippingDiscounts);
        Product::insert($products);
        foreach ($offers as $offer){
            Offer::create($offer);
        }
    }
}
