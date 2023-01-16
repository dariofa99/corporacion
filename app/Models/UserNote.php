<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Event;

class UserNote extends Model
{
    
    
    protected $table = 'user_notes';

     protected $fillable = [
        'note', 'type_status_id', 'user_id'
    ];

    public function user(){
       return $this->belongsTo(User::class,'user_id');
    }

    public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('userNote.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('userNote.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('userNote.deleted', $item);
	    });

	}
    
}
