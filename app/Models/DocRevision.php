<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocRevision
 * 
 * @property int $id
 * @property int|null $doc_id
 * @property string|null $create_date
 * @property int|null $editor_id
 * @property string|null $status
 * @property string|null $body
 * @property string|null $full_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DocRevision extends Model
{
	protected $table = 'doc_revision';

	protected $casts = [
		'doc_id' => 'int',
		'editor_id' => 'int'
	];

	protected $fillable = [
		'doc_id',
		'create_date',
		'editor_id',
		'status',
		'body',
		'full_date'
	];
}
