<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        DB::table('permissions')->insert([
            'id'=>1,
            'name' => 'crear_roles',
            'guard_name' => 'web',            
        ]);

        DB::table('permissions')->insert([
            'id'=>2,
            'name' => 'crear_permisos',
            'guard_name' => 'web',            
        ]);

        DB::table('permissions')->insert([
            'id'=>3,
            'name' => 'editar_permisos',
            'guard_name' => 'web',            
        ]);

        
        DB::table('permissions')->insert([
            'id'=>4,
            'name' => 'asignar_rol',
            'guard_name' => 'web',            
        ]);

        
        DB::table('permissions')->insert([
            'id'=>5,
            'name' => 'ver_usuarios',
            'guard_name' => 'web',            
        ]);

        
        DB::table('permissions')->insert([
            'id'=>6,
            'name' => 'crear_usuarios',
            'guard_name' => 'web',            
        ]);

        
        DB::table('permissions')->insert([
            'id'=>7,
            'name' => 'editar_usuarios',
            'guard_name' => 'web',            
        ]);

        
        DB::table('permissions')->insert([
            'id'=>8,
            'name' => 'eliminar_usuarios',
            'guard_name' => 'web',            
        ]);

        
        DB::table('permissions')->insert([
            'id'=>9,
            'name' => 'cambiar_estado_usuario',
            'guard_name' => 'web',            
        ]);
        DB::table('permissions')->insert([
            'id'=>10,
            'name' => 'matricular',
            'guard_name' => 'web',            
        ]);

        DB::table('permissions')->insert([
            'id'=>11,
            'name' => 'ver_inscripciones',
            'guard_name' => 'web',            
        ]);

        DB::table('permissions')->insert([
            'id'=>12,
            'name' => 'ver_pagos',
            'guard_name' => 'web',            
        ]);

        DB::table('permissions')->insert([
            'id'=>13,
            'name' => 'ver_administracion',
            'guard_name' => 'web',            
        ]);

        DB::table('permissions')->insert([
            'id'=>14,
            'name' => 'crear_estudiante',
            'guard_name' => 'web',            
        ]);

        DB::table('permissions')->insert([
            'id'=>15,
            'name' => 'ver_resumen',
            'guard_name' => 'web',            
        ]);

     


        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());
        $user = User::create([
            'name' => 'Admin',
            'categoria_id' => 1,
            'genero_id' => 1,
            'estado_id' => 1,
            'tipo_documento_id' => 1,
            'email' => 'admin@correo.com',
            'password' => Hash::make('admin'),
        ]);
        $user->roles()->attach($role);
    }
}
