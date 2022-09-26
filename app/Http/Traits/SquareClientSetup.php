<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ActivityLogs;
use Square\SquareClient;

trait SquareClientSetup
{
    public function squareClient()
    {
        $client = new SquareClient([
            'accessToken' => 'EAAAEPefWFFxVPnCOx3DgpgY3Dza4hpkUOSB_6i_RAIDQXyW7pNx0rcEfjsnQCv1',
            'environment' => 'sandbox',
        ]);
        return $client;
    }
}
