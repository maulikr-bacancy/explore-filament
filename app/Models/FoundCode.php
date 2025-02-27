<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FoundCode
 *
 * @property int $id
 * @property string|null $source
 *
 * @package App\Models
 */
class FoundCode extends Model
{
	protected $table = 'found_code';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'source'
	];
}
