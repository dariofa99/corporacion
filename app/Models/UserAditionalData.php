<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class UserAditionalData extends Model
{
    
    
    protected $table = 'user_aditional_data';

     protected $fillable = [
        'value', 'value_is_other', 'reference_data_id','reference_data_option_id','user_id'
    ];

   

    public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('userAdi.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('userAdi.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('userAdi.deleted', $item);
	    });

	} 
    
}
