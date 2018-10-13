<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:31
 */

namespace App\Models;

use Illuminate\Support\Collection;

class Role extends RoleModel {

	public $id;

	public $name;

	public $permissions;

	/**
	 * @return Collection
	 */
	public function getPermissions() : Collection {
		return $this->permissions;
	}

	/**
	 * @param Collection $permissions
	 */
	public function setPermissions(Collection $permissions ): void {

		// TODO : Must be an array of Permissions

		$this->permissions = $permissions;
	}

}

