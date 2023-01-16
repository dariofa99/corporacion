<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Event;

class CaseLog extends Model //implements Auditable
{
   use UploadFile;
  // use \OwenIt\Auditing\Auditable;
    protected $table="case_log"; //el modelo se va a relacionar con la tabla
    protected $fillable=['concept','description','type_log_id',
    'type_category_id','user_id','case_id','shared','notification_date','filing_date'];//que campos tiene la
    protected $notification_type;

    public function user(){
        return $this->belongsTo(User::class,'user_id');  
     }     
     
     public function case(){
        return $this->belongsTo(CaseM::class,'case_id');
     }     
      
    public function type_log(){     
        return $this->belongsTo(ReferenceTable::class,'type_log_id');    
     }

     public function type_category(){     
      return $this->belongsTo(ReferenceData::class,'type_category_id');    
   }

     
    /* public function files(){
        return $this->hasMany(LogFile::class,'case_log_id');
         
     }    */

     public function files(){
      return $this->belongsToMany(File::class,'caselog_has_files','caselog_id')
      ->withPivot('id','file_id','type_status_id')->withTimestamps(); 
   }  

   public function diarys(){
      return $this->belongsToMany(Diary::class,'caselog_has_diary','caselog_id')
      ->withPivot('id','diary_id','caselog_id')->withTimestamps(); 
   }  

    
   public static function boot() {
      parent::boot();
      static::created(function($item) {
          Event::dispatch('caselog.created', $item);
      });
      static::updated(function($item) {
           Event::dispatch('caselog.updated', $item);
      });
      static::deleted(function($item) {
          Event::dispatch('caselog.deleted', $item);
      });

  }
}