<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class Directory extends Model
{
    protected $table="directory"; //el modelo se va a relacionar con la tabla
    protected $fillable=['name','address','town','number_phone','email','is_trusted','type_status_id','origin','user_id'];//que campos tiene la

    public function aditional_data(){
        return $this->belongsToMany(AditionalData::class,'directory_has_addata','directory_id','data_id')
        ->withPivot('directory_id','data_id','user_id','type_data_id')->withTimestamps(); 
     } 
     public function user(){     
        return $this->belongsTo(User::class,'user_id');    
     }

     public function scopeGetData($query, $request)
    {

        if (trim($request->data)) { 

            if ($request->type and $request->data and ($request->type == 'general_search' || $request->type == 'type_status_id' || $request->type == 'created_at')) {
                return $query->Where(function ($query) use ($request) {
                    $query->orWhere('directory.name','like', "%{$request->data}%");
                    $query->orWhere('directory.email','like', "%{$request->data}%");
                    $query->orWhere('directory.number_phone','like', "%{$request->data}%");
                    $query->orWhere('directory.address','like', "%{$request->data}%");
                    $query->orWhere('directory.type_status_id', '=', $request->data);
                    $query->orWhereDate('directory.created_at', '=', $request->data);
                });
            }
        }
    }
     
     //Events
     public static function boot() {
      parent::boot();
      static::created(function($item) {
          Event::dispatch('directory.created', $item);
      });
      static::updated(function($item) {
          Event::dispatch('directory.updated', $item);
      });
      static::deleted(function($item) {
          Event::dispatch('directory.deleted', $item);
      });

  }     

}
