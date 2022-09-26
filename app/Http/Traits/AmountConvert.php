<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait AmountConvert
{
    public function convertAmount($amount)
    {
        return number_format($amount,2);
    }
}
