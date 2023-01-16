<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class PanicAlert extends Model
{
    protected $table = 'panic_alerts';
    protected $fillable = ['location', 'user_id','longitude','latitude','created_rg','city','address','type_status_id','status_description'];
    
    public function user(){     
        return $this->belongsTo(User::class,'user_id');    
     }
     public function type_status(){     
        return $this->belongsTo(ReferenceTable::class,'type_status_id');    
     } 

     public function cases(){
        return $this->belongsToMany(CaseM::class,'panic_alerts_has_case','panic_alert_id','case_id') 
        ->withPivot('case_id','panic_alert_id')->withTimestamps(); 
     }   

     public function scopeSearch($query, $request){    
            if (trim($request->data)){         
               if($request->type and $request->data and ($request->type=='case_asig')){                
                     return $query->Where(function($query) use($request){                  
                        if($request->data=="si"){
                           $query->where('case_id', '!=',"null");
                        }elseif($request->data=="no"){
                           $query->where('case_id',null);
                        }
                  });
               } 
               return $query->Where(function($query) use($request){
                           $query->orWhere('users.name', 'like',"%$request->data%")
                           ->orWhereDate('panic_alerts.created_at',$request->data)
                           ->orWhere('panic_alerts.type_status_id',$request->data);
               });     
            }
     }   
     
         //Events
         public static function boot() {
            parent::boot();
            static::created(function($item) {
                Event::dispatch('panicalert.created', $item);
            });
            static::updated(function($item) {
                Event::dispatch('panicalert.updated', $item);
            });
            static::deleted(function($item) {
                Event::dispatch('panicalert.deleted', $item);
            });
      
        }  

}
