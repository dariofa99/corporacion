<?php
namespace App\Repositories;

use App\Services\UsersService;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class UsersRepository extends BaseRepository implements UsersService{
   
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getUsersByPermissionName($permission) : Collection{

      $users = User::join('model_has_roles as ru', 'users.id','=', 'ru.model_id')
        ->join('roles','roles.id','=','ru.role_id')
        ->join('role_has_permissions','role_has_permissions.role_id','=','roles.id')
        ->join('permissions','permissions.id','=','role_has_permissions.permission_id')
        ->where('users.type_status_id','<>',15)
        ->where('permissions.name',$permission)
        ->select("users.id",'users.email','users.name')
        ->get();

        return $users;
    }

  
}




