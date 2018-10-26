<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:30
 */

namespace App\Models;

use JsonSerializable;

class Permission extends PermissionModel implements JsonSerializable {

	public $id;

	public $name;

	/**
	 * @param string $id
	 *
	 * @return Permission
	 */
	public static function find( string $id ): Permission {

		$model = PermissionModel::find( $id );

		$permission = new Permission();

		$permission->id   = $model->id;
		$permission->name = $model->name;

		return $permission;

	}

	public function jsonSerialize() {
		return [
			'id'           => $this->id,
			'firstName'    => $this->name
		];
	}

}