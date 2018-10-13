<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:57
 */

namespace App\Models;

class RoleFactory {

	/**
	 * @param $name
	 * @param array $permissions
	 * @param null $id
	 *
	 * @return Role
	 */
	public function get( $name, $permissions = [], $id = null ): Role {

		$role       = new Role();
		$role->name = $name;
		$role->id   = $id;
		$role->setPermissions( $permissions );

		return $role;
	}

}