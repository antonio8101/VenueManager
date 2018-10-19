<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:57
 */

namespace App\Models;

use Illuminate\Support\Collection;

class RoleFactory {

	/**
	 * @param $name
	 * @param Collection $permissions
	 * @param null $id
	 *
	 * @return Role
	 */
	public function get( $name, Collection $permissions, $id = null ): Role {

		$role       = new Role();
		$role->name = $name;
		$role->id   = $id;
		$role->setPermissions( $permissions );

		return $role;
	}

}