# checkout 
This Project has been generated By Lumen FrameWork v8.62
# Server Requirements
* PHP >= 7.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension

# Up&Running
 
* cd to project path
* composer install
* update .env with ur DB info
* php artisan migrate (command to migrate the db)
* php artisan db:seed (command to seed your database with the testing data)
* php -S localhost:8000 -t public (command to start the server)

# APIs Requests 
* create a invoice 
    * POST Request ENDPOINT :: /api/cart
    * Headers :: Content-Type: application/json
    * body {"items": "T-shirt Blouse Pants Shoes Jacket","currency":"USD"}
* Available Currencies codes => USD , EGP
* Available Items 
    * T-shirt
    * Blouse
    * Pants
    * Shoes
    * Pants
    * Jacket
    
* Available weights Unit :: KG , G

# Currencies && weights
    * Currency
        * i have set the Dollar as default currency for the 
        store (the values which admin insert products prices based on it)
        * i have created CurrencyService which handling the convert from currency to another 
        * To set  default currency for the store (ex : Dollar)  
        we have to set the value column for EGP row in currency table  to be equal to one ,
        Example  ::
        USD => value = 1 
        EGP => value = 15 
    * Weight 
        * i have set the KG as Default Weight
        *  WeightClassService To handling the convert from unit to another  
        * To set  default currency for the store (ex : gram) we have to change 
        the value column for  gram record to one (the same logic as currency)
        
# structure 
    * i have created a simple Service - Repository pattern (without using any package) 
    * please find all Services & repositories  in these locations 
     app/Providers/ServiceServiceProvider.php ,app/Providers/RepositoryServiceProvider.php
     
# offers :: i have divided the offers into two  types :: 
    * offers on products / bundle products
    * offers which apply on shipping methods 
    
# Testing
  * ./vendor/bin/phpunit  (command)   
         
