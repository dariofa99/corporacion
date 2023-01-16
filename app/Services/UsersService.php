<?php
namespace App\Services;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Collection;
interface UsersService {

    public function getUsersByPermissionName(String $role) : Collection;    

}