<?php
 namespace App\Facades;
 use Illuminate\Support\Facades\Facade;



class UploadFile extends Facade
{
    protected static function getFacadeAccessor() { return 'uploadFile'; }
    
    public function create(){
        dd("creando");
    }
}
