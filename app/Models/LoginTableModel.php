<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LoginTableModel extends Model
{
	protected $table = 'login_table';

	protected $fillable = [ 'user_id', 'token', 'active' ];

}
