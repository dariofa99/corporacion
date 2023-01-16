<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class Library extends Model
{
    protected $table="library"; //el modelo se va a relacionar con la tabla
    protected $fillable=['name_file','description','route_file','size','user_id','type_branch_law_id',
    'category_id','limit_date','type_status_id'];//que campos tiene la

     //Events
     public static function boot() {
        parent::boot();
        static::created(function($item) {
            Event::dispatch('libra.created', $item);
        });
        static::updated(function($item) {
            Event::dispatch('libra.updated', $item);
        });
        static::deleted(function($item) {
            Event::dispatch('libra.deleted', $item);
        });

    }     
}
