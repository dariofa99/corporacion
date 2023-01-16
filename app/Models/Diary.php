<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;

class Diary extends Model
{
    protected $table="diary"; //el modelo se va a relacionar con la tabla
    protected $fillable=['title','description','url','color','inicio','fin','type_status_id'];//que campos tiene la

    public function users(){
        return $this->belongsToMany(User::class,'diary_user','diary_id')
        ->withPivot('diary_id','user_id','owner','inspected'); 
     }  


     public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('diary.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('diary.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('diary.deleted', $item);
	    });
    }

}



