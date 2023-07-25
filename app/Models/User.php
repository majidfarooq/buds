<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
  use HasFactory, Notifiable, softDeletes, HasSlug;

  protected $finalStatus = "";
  protected $fillable = [
    'first_name',
    'last_name',
    'phone',
    'phone_alt',
    'business_name',
    'email',
    'recipient_name',
    'recipient_phone',
    'notes',
    'billing_coordinates',
    'billing_address1',
    'billing_address2',
    'billing_city',
    'billing_state',
    'billing_zip',
    'delivery_coordinates',
    'delivery_address1',
    'delivery_address2',
    'delivery_city',
    'delivery_state',
    'delivery_zip',
    'delivery_lat',
    'delivery_long',
    'billing_lat',
    'billing_long',
    'deactivated',
    'stripe_id',
    'email_verified_at',
    'password'
  ];

  public function getFinalStatusAttribute()
  {
    if ($this->attributes['deactivated'] === 1) {
      $this->finalStatus = "DEACTIVATED";
    } else {
      $this->finalStatus = "Active";
    }
    return $this->finalStatus;
  }

  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()
      ->generateSlugsFrom('first_name')
      ->saveSlugsTo('slug');
  }

  // public function packages()
  // {
  //   return $this->belongsToMany(Package::class, 'user_packages');
  // }

  public function user_packages()
  {
    return $this->hasMany(UserPackage::class);
  }
  public function getTotalSubscriptionAttribute()
  {
    return $this->user_packages->count();
  }
  public function payments()
  {
    return $this->hasManyThrough(UserPackagePayment::class, UserPackage::class);
  }


  public static function boot()
  {
    parent::boot();

    self::creating(function ($model) {
      // ... code here
    });

    self::updating(function (User $user) {
      // if ($user->wasChanged('deactivated') && ($user->deactivated === 1)) {
      //   UserPackage::where('user_id', $user->id)->delete();
      // } else {
      // }
    });

    self::updated(function (User $user) {

      // if ($user->wasChanged('deactivated') && ($user->deactivated === 1)) {
      //   UserPackage::where('user_id', $user->id)->delete();
      // } else {
      // }
    });

    self::deleting(function ($model) {
      // ... code here
    });

    self::deleted(function ($model) {
      // ... code here
    });
  }




  protected $hidden = [
    'password',
    'remember_token',
  ];
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
}
