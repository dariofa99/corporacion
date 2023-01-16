<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class PaymentCredit extends Model
{
    protected $table="payment_credits"; //el modelo se va a relacionar con la tabla
    protected $fillable=['value','type_status_id','limit_payment_date',
    'payment_date','payment_id','payment_method_id','description_pmethod'];//que campos tiene la

     
   
       
    
    public function payment(){     
        return $this->belongsTo(Payment::class,'payment_id');    
     }

     public function status(){     
        return $this->belongsTo(ReferenceTable::class,'type_status_id');    
     }

    public function getColorStatus(){


      switch ($this->type_status_id) {
         case 110:
            $color = 'success';
            break;
         case 111:
               $color = 'warning';
         break;   
         
         default:
         $color = 'light';
            break;
      }
return $color;

    }


 

    

}