<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 * 
 * @property int $id
 * @property string|null $create_date
 * @property string|null $title
 * @property int|null $author_id
 * @property int|null $public
 * @property Carbon|null $full_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Document extends Model
{
	protected $table = 'document';

	protected $casts = [
		'author_id' => 'int',
		'public' => 'int',
		'full_date' => 'datetime'
	];

	protected $fillable = [
		'create_date',
		'title',
		'author_id',
		'public',
		'full_date'
	];
}
