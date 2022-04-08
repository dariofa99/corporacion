<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Event;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password','identification_number','phone_number','type_identification_id',
        'address','image','type_status_id','town'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sessions(){
        return $this->hasMany(SessionAdmin::class,'user_id');
     }

     
     public function diarys(){
        return $this->belongsToMany(Diary::class,'diary_user','user_id')
        ->withPivot('diary_id','user_id','owner','inspected')->withTimestamps(); 
     }  

     public function cases(){
        return $this->belongsToMany(CaseM::class,'user_cases','user_id','case_id')
        ->withPivot('user_id','case_id','type_defendant')->withTimestamps();
     }

     public function type_identification(){
        return $this->belongsTo(ReferenceTable::class);
     }

     public function notes(){
        return $this->hasMany(UserNote::class,'user_id','id');
     }

     public function type_status(){
        return $this->belongsTo(ReferenceTable::class,'type_status_id');
     }


     public function notifications_mail(){
        return $this->hasMany(UserMailNotification::class,'user_id','id');
     }

     public function receptions(){
        return $this->hasMany(Reception::class,'user_id','id');
     }

     public function aditional_data(){
        return $this->hasMany(UserAditionalData::class,'user_id','id');
     }

    public function getData($section=null){
         $data = \DB::table('user_data') 
        ->join('references_data as rt','rt.id','=','user_data.type_data_id')
        ->where(['user_id'=>$this->id,'section'=>$section])->get();        
        return $data;
    }

    public function getDataValue($type_data_id=null){
        $data = \DB::table('user_data')
            ->join('references_data as rt','rt.id','=','user_data.type_data_id')
            ->where(['user_id'=>$this->id,'user_data.type_data_id'=>$type_data_id])->first();     
        if(!$data) return false;   
            return $data;
   }

   public function getAditionalDataValue($reference_data_id=null,$reference_data_option_id=null){
    $data = $this->aditional_data()
    ->where([
        'reference_data_id'=>$reference_data_id,
        'reference_data_option_id'=>$reference_data_option_id,
    ])->first();
    
    /* DB::table('user_aditional_data')        
        ->where(['user_id'=>$this->id,'type_data_id'=>$type_data_id])
        ->select('user_static_data.id as id','user_static_data.value_is_other','rt.name','rt.id as type_data_id')->first();     
     */
    if(!$data) return false;   
    return true;
}

public function getAditionalDataValueById($reference_data_option_id=null){
    $data = $this->aditional_data()
    ->where([
       'reference_data_id'=>$reference_data_option_id,
    ])->first();
    
    /* DB::table('user_aditional_data')        
        ->where(['user_id'=>$this->id,'type_data_id'=>$type_data_id])
        ->select('user_static_data.id as id','user_static_data.value_is_other','rt.name','rt.id as type_data_id')->first();     
     */
    if(!$data) return false;   
    return $data;
}

public function getAditionalDataValueOther($reference_data_id=null,$reference_data_option_id=null){
    $data = $this->aditional_data()
    ->where([
        'reference_data_id'=>$reference_data_id,
        'reference_data_option_id'=>$reference_data_option_id,
    ])->first();
    
    /* DB::table('user_aditional_data')        
        ->where(['user_id'=>$this->id,'type_data_id'=>$type_data_id])
        ->select('user_static_data.id as id','user_static_data.value_is_other','rt.name','rt.id as type_data_id')->first();     
     */
    if(!$data) return false;   
    return $data->value_is_other;
}


    public function getCasesUrl(){
          //se llamadesde la opcion clientes para determinar si abre chat o muestra casos
        if(count($this->receptions()->where('type_status_id',142)->get()) > 0){
            $url = "/recepciones/".$this->receptions->where('type_status_id',142)->first()->id."/edit";
            return $url;
        }
        if (count($this->cases) <= 0) {
            return '#';
        } elseif (count($this->cases) == 1) {
            $url = "/casos/".$this->cases[0]->id."/edit";
            return $url;
        } else {
            $url = "/casos?type=identification_number&data=".$this->identification_number;
            return $url;
        }
 
    }  


    public static function boot() {
	    parent::boot();
	    static::created(function($item) {
	        Event::dispatch('user.created', $item);
	    });
	    static::updated(function($item) {
            Event::dispatch('user.updated', $item);
	    });
	    static::deleted(function($item) {
	        Event::dispatch('user.deleted', $item);
	    });
    }
}
