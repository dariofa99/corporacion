<?php
namespace App\Services;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UsersService {

    public function getUsersByPermissionName(String $role) : Collection;
    public function insertData(Request $request);    

}