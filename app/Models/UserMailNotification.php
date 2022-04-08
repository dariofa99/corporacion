<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Event;
class UserMailNotification extends Model
{
    protected $table = 'users_mail_notification';
    protected $fillable = [
        'show_notification_date',
        'token',
        'user_id',
        'caselog_id',
        'access_address'
    ];

    public function log(){     
        return $this->belongsTo(CaseLog::class,'caselog_id');    
    }

    public function user(){     
        return $this->belongsTo(User::class,'user_id');    
    }

    public function getColor(){     
        if($this->token!=null){
            return 'danger';
        }
        return 'success';    
     }
     public function getMsgTooltip(){     
        if($this->token!=null){
            return 'Notificación sin revisar';
        }
        return 'Notificación revisada';    
     }

     public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('userMailNoti.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('userMailNoti.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('userMailNoti.deleted', $item);
	    });

	}

}
