<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocTag
 * 
 * @property int $id
 * @property int|null $doc_id
 * @property string|null $tag
 * @property Carbon|null $create_date
 * @property int|null $removed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DocTag extends Model
{
	protected $table = 'doc_tag';

	protected $casts = [
		'doc_id' => 'int',
		'create_date' => 'datetime',
		'removed' => 'int'
	];

	protected $fillable = [
		'doc_id',
		'tag',
		'create_date',
		'removed'
	];
}
