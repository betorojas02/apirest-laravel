<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongsToUser extends Exception
{
    //


    public function render()
    {
        // dd("assaads");
        return ['errors' => 'Product Not Belongs to user '];
    }
}
