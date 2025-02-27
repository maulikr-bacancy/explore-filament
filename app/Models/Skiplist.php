<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Skiplist
 *
 * @property int $id
 * @property int|null $practice_id
 * @property binary|null $monthly_newsletter
 * @property binary|null $doctor_newsletter
 * @property binary|null $eval_newsletter
 * @property text|null $notes
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Skiplist extends Model
{
	protected $table = 'skiplist';

	protected $casts = [
		'practice_id' => 'int',
	];

	protected $fillable = [
		'practice_id',
		'monthly_newsletter',
		'doctor_newsletter',
		'eval_newsletter',
		'notes'
	];
	
	public function practice() {
		return $this->belongsTo(Practice::class, 'practice_id' );
	}
}
