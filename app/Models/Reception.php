<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class Reception extends Model
{
    protected $table = 'receptions';
    protected $fillable = ['number', 'user_id','token','type_status_id'];
    
    public function user(){     
        return $this->belongsTo(User::class,'user_id');    
     }
     public function type_status(){     
        return $this->belongsTo(ReferenceTable::class,'type_status_id');    
     } 

     public function case(){
        return $this->belongsTo(CaseM::class,'id','reception_id'); 
     }  

     //Events
     public static function boot() {
      parent::boot();
      static::created(function($item) {
          Event::dispatch('reception.created', $item);
      });
      static::updated(function($item) {
          Event::dispatch('reception.updated', $item);
      });
      static::deleted(function($item) {
          Event::dispatch('reception.deleted', $item);
      });

  }    
     
     
      
}
