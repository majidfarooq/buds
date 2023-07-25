<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackagePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_package_id',
        'type',
        'quantity',
        'amount',
        'payment_date',
        'description',
        'transection_id',
        'status',
        'attachment'
    ];


    public function user_package()
    {
        return $this->belongsTo(UserPackage::class)->withTrashed();
    }
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
    public function deliveriesCount()
    {
        return $this->hasMany(Delivery::class);
    }
    public function getRemainingQuantityAttribute()
    {
        $quentity = $this->quantity;
        $deliveries = $this->deliveries->count();

        return $quentity - $deliveries;
    }
}
