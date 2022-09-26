<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ActivityLogs;

trait CreateLog
{
    public function createOrUpdateLogs($data)
    {
        ActivityLogs::create($data);
    }
}
