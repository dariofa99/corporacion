<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Traits\UploadFile;

class Payment extends Model
{
   use UploadFile;
   
    protected $table="payments"; //el modelo se va a relacionar con la tabla
    protected $fillable=['value','num_payments',
    'description','concept','shared','case_id',
    'type_status_id','type_category_id','type_payment_id','type_periodpay_id'];//que campos tiene la

     
   
       
    public function users(){
        return $this->belongsToMany(User::class,'user_cases','case_id')
        ->withPivot('user_id','case_id','type_user_id','status','id'); 
     }        
      
    public function case(){     
        return $this->belongsTo(CaseM::class,'case_id');    
     }

     public function status(){     
        return $this->belongsTo(ReferenceTable::class,'type_status_id');    
     }

     public function category(){     
      return $this->belongsTo(ReferenceTable::class,'type_category_id');    
   }

   public function type_payment(){     
      return $this->belongsTo(ReferenceTable::class,'type_payment_id');    
   }

   public function credits(){
      return $this->hasMany(PaymentCredit::class,'payment_id');
   } 
      
   public function files(){
      return $this->belongsToMany(File::class,'payment_has_files','payment_id')
      ->withPivot('id','payment_id','file_id','type_category_id','type_status_id')->withTimestamps(); 
   }  

 
   public function getColorStatus(){


      switch ($this->type_status_id) {
         case 50:
            $color = 'primary';
            break;
         case 49:
               $color = 'success';
         break;   
         
         default:
         $color = 'light';
            break;
      }
            return $color;

    }
    

}