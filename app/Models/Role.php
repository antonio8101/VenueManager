<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:31
 */

namespace App\Models;

use App\Facades\RoleFactory;
use Illuminate\Support\Collection;
use JsonSerializable;

class Role extends RoleModel implements JsonSerializable {




	public $id;

	public $name;

	public $permissions;

	public function jsonSerialize() {
		return [
			'Role' => [
				'id'          => $this->id,
				'name'        => $this->name,
				'permissions' => $this->permissions
			]
		];
	}

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

	/**
	 * @param string $id
	 *
	 * @return Role
	 */
	public static function find( string $id ): Role {

		$model = RoleModel::find( $id );

		$permissions = new Collection();

		$rolePermissions = RolesPermissions::where( 'role_id', $model->id )->get();

		foreach ( $rolePermissions as $rolePermission ) {

			$permission = Permission::find( $rolePermission->permission_id );

			$permissions->push( $permission );

		}

		$role = RoleFactory::get( $model->name, $permissions, $model->id );

		return $role;

	}

}

