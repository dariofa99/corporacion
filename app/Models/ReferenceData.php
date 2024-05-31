<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class ReferenceData extends Model
{
    protected $table="references_data"; //el modelo se va a relacionar con la tabla
    protected $fillable=['name','short_name','categories','table','section','is_visible','type_data_id'];//que campos tiene la

    
    
    public function getCategory(){
    if($this->categories=='type_data_case'){
        return 'Datos del caso';
    }elseif ($this->categories=='type_data_user') {
        return 'Usuarios';
    }elseif ($this->categories=='type_category_log') {
        return 'Bitacoras';
    }elseif ($this->categories=='type_data_directory') {
        return 'Directorio';
    }else{
        return $this->categories;
    }


    }

    public function logs(){     
        return $this->hasMany(CaseLog::class,'type_category_id','id');    
     }

     public function type_data(){     
        return $this->belongsTo(ReferenceTable::class,'type_data_id','id');    
     }

     public function users(){
        return $this->belongsToMany(User::class,'user_data','type_data_id')
        ->withPivot('user_id','value')->withTimestamps(); 
     } 

     public function type_aditional_data(){
        return $this->belongsToMany(AditionalData::class,'directory_has_addata','type_data_id','data_id')
        ->withPivot('directory_id','data_id','user_id','type_data_id')->withTimestamps(); 
     } 

     public function options(){
        return $this->hasMany(ReferenceDataOptions::class,'references_data_id','id'); 
     } 

     

    public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('refdata.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('refdata.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('refdata.deleted', $item);
	    });
    }

}
