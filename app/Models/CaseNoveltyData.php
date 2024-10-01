<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class CaseNoveltyData extends Model
{
    
    
    protected $table = 'case_novelty_data';

     protected $fillable = [
        'value', 'value_is_other', 
		'reference_data_id',
		'reference_data_option_id',
		'case_id'
    ];

    public function question(){
        return $this->belongsTo(ReferenceData::class,'reference_data_id'); 
     } 

}
