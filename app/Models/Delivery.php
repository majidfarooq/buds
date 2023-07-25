<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_day_id',
        'user_package_id',
        'user_package_payment_id',
        'status',
        'route'
    ];
    protected $appends = ['delivery_type'];

    public function delivery_day()
    {
        return $this->belongsTo(DeliveryDay::class);
    }
    public function user_package()
    {
        return $this->belongsTo(UserPackage::class)->withTrashed();
    }
    public function payment()
    {
        return $this->belongsTo(UserPackagePayment::class);
    }

    public function package()
    {
        return $this->hasOneThrough(UserPackage::class, Package::class);
    }

    public function getDeliveryTypeAttribute()
    {
        return $this->user_package->delivery_type;
    }
    public function getCostAttribute()
    {
        return $this->package->amount;
    }
    public function getProfitAttribute()
    {
        $cost = $this->package->amount;
        $mark_up = $this->package->mark_up;
        return ($cost * $mark_up) * 100;
    }
}
