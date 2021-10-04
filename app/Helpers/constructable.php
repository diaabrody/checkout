<?php


namespace App\Helpers;


trait constructable
{
    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array([$this,$f],$a);
        }
    }

}
