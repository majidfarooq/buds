<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_date',
        'deliver_to',
        'status'
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function getTotalDeliveriesAttribute()
    {
        return $this->deliveries->where('status', '!=', 'Canceled')->count();
    }
    public function getPaiddeliveriesAttribute()
    {
        return $this->deliveries->where('status', 'Paid')->count();
    }
    public function getFaileddeliveriesAttribute()
    {
        return $this->deliveries->where('status', 'Failed')->count();
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // ... code here
        });

        self::created(function (DeliveryDay $delivery_day) {
            $day_id = $delivery_day->id;
            $deliver_to = $delivery_day->deliver_to;

            if ($deliver_to == 'friday') {
                $userpackages = UserPackage::where('status', 'Active')->where('day', 'friday')->get();
            } elseif ($deliver_to == 'thursday') {
                $userpackages = UserPackage::where('status', 'Active')->where('day', 'thursday')->get();
            } elseif ($deliver_to == 'both') {
                $userpackages = UserPackage::where('status', 'Active')->get();
            }

            foreach ($userpackages as $userPackage) {
                //'delivery_day_id','user_package_id',status
                if ($userPackage->type == 'bi-monthly') {
                    $previousDay = DeliveryDay::where('delivery_date', '<', $delivery_day->delivery_date)->where('deliver_to', $delivery_day->deliver_to)->orderBy('delivery_date', 'desc')->first();
                    $up_delivery = Delivery::where('delivery_day_id', $previousDay->id)->where('user_package_id', $userPackage->id)->first();
                    if ($up_delivery) {
                    } else {
                        $delivery = new Delivery();
                        $delivery['delivery_day_id'] = $day_id;
                        $delivery['user_package_id'] = $userPackage->id;
                        if ($userPackage->status == 'Suspended') {
                            $delivery['status'] = $userPackage->status;
                        }
                        $delivery->save();
                    }
                } else {
                    $delivery = new Delivery();
                    $delivery['delivery_day_id'] = $day_id;
                    $delivery['user_package_id'] = $userPackage->id;
                    if ($userPackage->status == 'Suspended') {
                        $delivery['status'] = $userPackage->status;
                    }
                    $delivery->save();
                }
            }
        });

        self::updating(function ($model) {
            // ... code here
        });

        self::updated(function ($model) {
            // ... code here
        });

        self::deleting(function ($model) {
            // ... code here
        });

        self::deleted(function ($model) {
            // ... code here
        });
    }
}
