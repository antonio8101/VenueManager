<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueModel extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'venues';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'active', 'name', 'address_id',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [

	];

	/**
	 * Get the phone record associated with the address.
	 */
	public function address()
	{
		return $this->hasOne('App\Models\AddressModel', 'id', 'address_id');
	}


	/**
	 * Set Active value to false
	 *
	 * @param string $id
	 */
	public static function softDeleteModel( string $id ) {

		$model = VenueModel::where( 'id', $id )->first();

		$model->active = 0;

		$model->save();

	}

}
