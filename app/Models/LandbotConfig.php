<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $practice_id
 * @property string $landbot_checked
 * @property string $landbot_deployed
 * @property string $landbot_version
 * @property string $ar_url
 * @property string $locations_url
 * @property string $insurance_url
 * @property string $paperwork_url
 * @property string $use_ar
 * @property string $use_locations
 * @property string $use_paperwork
 * @property string $use_insurance
 * @property string $use_social
 * @property string $use_hours
 * @property string $hours
 * @property string $landbot_legacy
 * @property integer $total_count
 * @property integer $new_count
 * @property integer $previous_finished
 * @property integer $previous_count
 */
class LandbotConfig extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'landbot_config';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'practice_id';
	
	
	/**
	 * Get the practice that owns the landbot config.
	 */
	public function practices() {
		return $this->belongsTo( Practice::class, 'practice_id' );
	}

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['landbot_checked', 'landbot_deployed', 'landbot_version', 'ar_url', 'locations_url', 'insurance_url', 'paperwork_url', 'use_ar', 'use_locations', 'use_paperwork', 'use_insurance', 'use_social', 'use_hours', 'hours', 'landbot_legacy', 'total_count', 'new_count', 'previous_finished', 'previous_count'];
}
