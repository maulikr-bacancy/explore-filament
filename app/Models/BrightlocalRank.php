<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BrightlocalRank
 *
 * @property int $id
 * @property int|null $practice_id
 * @property int|null $clinic_id
 * @property int|null $brightlocal_lsrc
 * @property int|null $week_number
 * @property int|null $year_number
 * @property Carbon|null $last_processed
 * @property int|null $lsrc_google_map
 * @property int|null $lsrc_google_organic
 * @property string|null $lsrc_phrase
 * @property string|null $clinic_phrase
 * @property Carbon|null $date_created
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BrightlocalRank extends Model
{
	protected $table = 'brightlocal_rank';

	protected $casts = [
		'practice_id' => 'int',
		'clinic_id' => 'int',
		'brightlocal_lsrc' => 'int',
		'week_number' => 'int',
		'year_number' => 'int',
		'last_processed' => 'datetime',
		'lsrc_google_map' => 'int',
		'lsrc_google_organic' => 'int',
		'date_created' => 'datetime'
	];

	protected $fillable = [
		'practice_id',
		'clinic_id',
		'brightlocal_lsrc',
		'week_number',
		'year_number',
		'last_processed',
		'lsrc_google_map',
		'lsrc_google_organic',
		'lsrc_phrase',
		'clinic_phrase',
		'date_created'
	];

    public function practice()
    {
        return $this->belongsTo('App\Models\Practice', 'practice_id');
    }

    public function brightlocalranks() {
        return $this->hasMany( BrightlocalRank::class, 'clinic_id' );
    }
}
