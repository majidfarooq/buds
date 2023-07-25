<?php


namespace App\Http\Libraries;


use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class Helpers
{

  /** Upload file
   * @param file $file
   * @param location
   * @return string
   */


    protected $settings;
    public function __construct()
    {
        $this->settings = new Setting();
    }

  public function uploadFile($file = null, $location = null)
  {
    $path = '';
    if (!is_null($file) && !is_null($location)) {
      $file = $file;
      $path = $file->store('public/' . $location);
      return $path;
    }
    return $path;
  }
  public function encrypt_string($string_to_encrypt)
  {
    $id = '_' . $string_to_encrypt;
    $timestamp = time();
    $randomKey = rand();
    $key = base64_encode($timestamp . $randomKey . $id);
    return $key;
  }

  public function decrypt_string($encrypted_string)
  {
    $password = base64_decode($encrypted_string);
    $password = explode('_', $password);
    return $password[1];
  }

  public function amount_convert($amount){
    return number_format($amount,2);
  }


  public function getServiceValue($key){

        if(!empty($key)){
            $setting=$this->settings->where('field_key',$key)->select('field_value')->first();
            if(isset($setting->field_value) && !empty($setting->field_value)){
                return $setting->field_value;
            }else{
                return false;
            }
        }else{
            return false;
        }
  }

}
