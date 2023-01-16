<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class File extends Model
{
    protected $table="files"; //el modelo se va a relacionar con la tabla
    protected $fillable=['original_name','encrypt_name','path','size'];//que campos tiene la

   
       
    public function category(){
        return $this->belongsToMany(ReferenceTable::class,'payment_has_files','file_id','type_category_id')
        ->withPivot('id','payment_id','file_id','type_category_id')->withTimestamps(); 
     } 
     
     public function log(){
        return $this->belongsToMany(CaseLog::class,'caselog_has_files','file_id','caselog_id')
        ->withPivot('id','caselog_id','file_id','type_status_id')->withTimestamps(); 
     }  

}