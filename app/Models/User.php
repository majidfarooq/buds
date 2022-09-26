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
    'deactivated',
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


  protected $hidden = [
    'password',
    'remember_token',
  ];
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
}
