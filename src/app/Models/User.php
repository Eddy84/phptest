<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey='id';
	protected $table = 'users';

	protected $casts =
	[
		'name' => 'string',
	];
}
