<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPackage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'package_id',
        'type',
        'day',
        'status',
        'suspended_until',
        'description',
    ];
    protected $appends = ['delivery_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payments()
    {
        return $this->hasMany(UserPackagePayment::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }


    public function getDeliveryTypeAttribute()
    {
        return $this->package->type;
    }
    public function getTotalDeliveriesWeekAttribute()
    {
        return $this->deliveries->count();
    }
    // 'Pending','Canceled','Paid','Failed'

    public function getRemainingDeliveriesAttribute()
    {
        $quentity = $this->payments->sum('quantity');
        $deliveries = $this->deliveries->whereIn('status', ['Paid', 'Failed'])->count();
        return $quentity - $deliveries;
        // return 6;
    }
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // ... code here
        });

        self::created(function (UserPackage $user_package) {
            $upcoming_dd = DeliveryDay::where('delivery_date', '>=', Carbon::today())->where('deliver_to', $user_package->day)->where('status', 'Pending')->orderBy('delivery_date', 'desc')->get();
            $counter = 1;
            if (!empty($upcoming_dd)) {
                foreach ($upcoming_dd as $delivery_day) {
                    if ($counter % 2 == 0 && $user_package->type == 'bi-monthly') {
                    } else {
                        $delivery = new Delivery();
                        $delivery['delivery_day_id'] = $delivery_day->id;
                        $delivery['user_package_id'] = $user_package->id;
                        if ($user_package->status == 'Suspended') {
                            $delivery['status'] = $user_package->status;
                        }
                        $delivery->save();
                    }
                    $counter++;
                }
            }
        });

        self::updating(function ($model) {
            // ... code here
        });

        self::updated(function (UserPackage $user_package) {
            if ($user_package->wasChanged('status') && ($user_package->status === 'suspended' || $user_package->status === 'in Active')) {
                Delivery::with('delivery_day')->whereHas('delivery_day', function ($q) {
                    return $q->where('delivery_date', '>=', Carbon::today())->where('status', 'Pending');
                })->where('user_package_id', $user_package->id)->update(["status" => "Canceled"]);
            } elseif ($user_package->wasChanged('status') && $user_package->status === 'active') {
                Delivery::with('delivery_day')->whereHas('delivery_day', function ($q) {
                    return $q->where('delivery_date', '>=', Carbon::today())->where('status', 'Pending');
                })->where('user_package_id', $user_package->id)->update(["status" => "Pending"]);
            }
        });

        self::deleting(function (UserPackage $user_package) {
            Delivery::where('user_package_id', $user_package->id)->where('status', 'Pending')->delete();
        });

        self::deleted(function ($model) {
            // ... code here
        });
    }
}
