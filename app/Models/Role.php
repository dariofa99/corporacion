<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
   
    
    protected $table = 'roles';

     protected $fillable = [
        'name', 'name', 'description'
    ];

   /* public function permissions(){
       return $this->belongsToMany(Permission::class,'permission_role')
       ->withPivot('permission_id','role_id');
    }*/
    
}
