<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class LogFile extends Model
{
    protected $table="log_files"; //el modelo se va a relacionar con la tabla
    protected $fillable=['concept','description','type_log_id','user_id','size'];//que campos tiene la

    public function user(){
        return $this->belongsTo(User::class,'user_id');
        
     } 
     
     public function log(){
        return $this->belongsTo(CaseLog::class);
        
     } 
      
       
       

    
    

}