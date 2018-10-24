<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'addresses';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
		'city',
		'street',
		'country_id',
		'country_name',
		'zip_code',
		'latitude',
		'longitude'
	];

}
