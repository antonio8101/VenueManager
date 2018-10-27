<?php

use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $userPermissions = [
		    'CanViewMap',
	    ];
	    $superVisorPermissions = [
		    'CanManageUsers',
		    'CanManageVenues'
	    ];
	    $adminPermissions = [
		    'CanCreateUsers',
		    'CanEditUsers',
		    'CanDeleteUsers',
		    'CanCreateVenues',
		    'CanEditVenues',
		    'CanDeleteVenues',
	    ];

	    $permissions = array_merge($userPermissions, $superVisorPermissions, $adminPermissions);

	    foreach ($permissions as $value){
		    \Illuminate\Support\Facades\DB::table('permissions')->insert([
			    'name' => $value
		    ]);
	    }

	    $roles = [\App\GlobalConsts::__ADMIN_ROLE__, \App\GlobalConsts::__SUPERVISOR_ROLE__, \App\GlobalConsts::__USER_ROLE__];

	    foreach ($roles as $role){

		    \Illuminate\Support\Facades\DB::table('roles')->insert([
			    'name' => $role
		    ]);

	    }

	    $rolePermissions = [
		    $roles[0] => array_merge($userPermissions, $superVisorPermissions, $adminPermissions),
		    $roles[1] => array_merge($userPermissions, $superVisorPermissions),
		    $roles[2] => array_merge($userPermissions, $superVisorPermissions),
	    ];

	    foreach ($rolePermissions as $role => $permissions){

		    $roleId = \App\Models\RoleModel::where('name', $role)->first()->id;

		    foreach ($permissions as $permission){

			    $permissionId = \App\Models\PermissionModel::where('name', $permission)->first()->id;

			    \Illuminate\Support\Facades\DB::table('roles_permissions')->insert([
				    'role_id' => $roleId,
				    'permission_id' => $permissionId
			    ]);
		    }

	    }

    }
}
