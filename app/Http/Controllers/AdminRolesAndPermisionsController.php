<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRolesAndPermisionsController extends Controller
{
    public function __construct(){
        $this->middleware('permission:asig_rol_permisos',['only' => ['index']]);
    }
   
    public function index(Request $request){
        $roles = Role::all();
        $permissions = Permission::all();

     //   $user = \Auth::user();
      //  $user->assignRole('Amatai');
   // $role = Role::where('name' , 'Admin')->first();

      //  $role->givePermissionTo(Permission::all());

        return view("content.roles_permissions.admin_panel",compact('roles','permissions'));
    }

    public function syncRolPermissions(Request $request){
        $role = Role::find($request->role_id);
        $permission = Permission::find($request->permission_id);
        if($request->ismethod == 'insert'){
            $role->givePermissionTo($permission);
        }else{
            $role->revokePermissionTo($permission);
        }
    }

    public function adminRoles(Request $request){
        $roles = Role::all();
        return view("content.roles_permissions.admin_roles",compact("roles"));
    }

    public function storeRole(Request $request){
        $role = Role::create($request->all());
        $roles = Role::all();
        $view = view("content.roles_permissions.ajax.list_roles",compact("roles"))->render();
        return response()->json([
            'view'=>$view
        ]);
    }
    public function updateRole(Request $request){
        $role = Role::find($request->id);
        $role->fill($request->all());
        $role->save();
        $roles = Role::all();
        $view = view("content.roles_permissions.ajax.list_roles",compact("roles"))->render();
        return response()->json([
            'view'=>$view
        ]);

    }

    public function deleteRole(Request $request){       
        $role = Role::find($request->id);
        $role->delete();    
        $roles = Role::all();
        $view = view("content.roles_permissions.ajax.list_roles",compact("roles"))->render();
        return response()->json([
            'view'=>$view
        ]);
    }

/////////////////////////////////////////////////////////////////
    public function adminPermissions(Request $request){
        $permissions = Permission::all();
        return view("content.roles_permissions.admin_permissions",compact("permissions"));
    }

    public function storePermission(Request $request){
        $permission = Permission::create($request->all());
        $permissions = Permission::all();
        $view = view("content.roles_permissions.ajax.list_permissions",compact("permissions"))->render();
        return response()->json([
            'view'=>$view
        ]);
    }
    public function updatePermission(Request $request){
        $permission = Permission::find($request->id);
        $permission->fill($request->all());
        $permission->save();
        $permissions = Permission::all();
        $view = view("content.roles_permissions.ajax.list_permissions",compact("permissions"))->render();
        return response()->json([
            'view'=>$view
        ]);

    }

    public function deletePermission(Request $request){
       
        $permission = Permission::find($request->id);
        $permission->delete();    
        $permissions = Permission::all();
        $view = view("content.roles_permissions.ajax.list_permissions",compact("permissions"))->render();
        return response()->json([
            'view'=>$view
        ]);

    }
}
