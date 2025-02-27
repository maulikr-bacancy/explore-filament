<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lateststatus
 *
 * @property int $id
 * @property int|null $practice_id
 * @property string|null $description
 * @property int|null $whomade
 * @property Carbon|null $datecreated
 * @property string|null $statustype
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Lateststatus extends Model
{
	protected $table = 'lateststatus';

	protected $casts = [
		'practice_id' => 'int',
		'whomade' => 'int',
		'datecreated' => 'datetime'
	];

	protected $fillable = [
		'practice_id',
		'description',
		'whomade',
		'datecreated',
		'statustype'
	];
	
	
	public function practice() {
		return $this->belongsTo( Practice::class, 'practice_id' );
	}
	
	public function security() {
		return $this->belongsTo( Security::class, 'whomade' );
	}
	
	
}
