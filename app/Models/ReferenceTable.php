<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceTable extends Model
{
    protected $table="references_table"; //el modelo se va a relacionar con la tabla
    protected $fillable=['name','categories','table'];//que campos tiene la

}
