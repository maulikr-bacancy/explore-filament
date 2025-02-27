<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocTemplate
 * 
 * @property int $id
 * @property string|null $title
 * @property int|null $editor_id
 * @property Carbon|null $create_date
 * @property string|null $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DocTemplate extends Model
{
	protected $table = 'doc_template';

	protected $casts = [
		'editor_id' => 'int',
		'create_date' => 'datetime'
	];

	protected $fillable = [
		'title',
		'editor_id',
		'create_date',
		'body'
	];
}
