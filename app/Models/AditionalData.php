<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class AditionalData extends Model
{
    protected $table="aditional_data"; //el modelo se va a relacionar con la tabla
    protected $fillable=['value','section','is_list'];//que campos tiene la

    public function type_aditional_data(){
        return $this->belongsToMany(ReferenceData::class,'directory_has_addata','data_id','type_data_id')
        ->withPivot('directory_id','data_id','user_id','type_data_id')->withTimestamps(); 
     } 

     public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('adtd.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('adtd.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('adtd.deleted', $item);
	    });
    }

}
