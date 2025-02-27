<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Config
 *
 * @property int $id
 * @property int $practice_id
 * @property string $code
 * @property string $value
 * @property Carbon $date_added
 * @property string|null $button
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Config extends Model
{
	protected $table = 'config';

	protected $casts = [
		'practice_id' => 'int',
		'date_added' => 'datetime'
	];

	protected $fillable = [
		'practice_id',
		'code',
		'value',
		'date_added',
		'button'
	];

    public function practice() {
        return $this->belongsTo( Practice::class,'practice_id');
    }
}
