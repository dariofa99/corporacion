<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class ReferenceDataOptions extends Model
{
    protected $table="references_data_options"; //el modelo se va a relacionar con la tabla
    protected $fillable=['value','status','active_other_input','references_data_id'];//que campos tiene la

     
    public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('refdataop.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('refdataop.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('refdataop.deleted', $item);
	    });
    }

}
