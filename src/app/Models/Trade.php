<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
	protected $table = 'trades';

	public $timestamps = false;

	protected $fillable =
	[
		'id',
		'type',
		'userId',
		'symbol',
		'shares',
		'price',
		'timestamp',
	];

	protected $casts =
	[
		'id' => 'integer',
		'type' => 'string',
		'userId' => 'integer',
		'symbol' => 'string',
		'shares' => 'integer',
		'price' => 'float',
		'timestap' => 'date'
	];
}
