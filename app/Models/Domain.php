<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Domain
 * 
 * @property int $id
 * @property int|null $practice_id
 * @property string|null $domain
 * @property string|null $monitor
 * @property int|null $statuscake
 * @property int|null $emails
 * @property int|null $emailchecked
 * @property string|null $wwwip
 * @property string|null $ip
 * @property string|null $ns
 * @property string|null $mx
 * @property string|null $registrar
 * @property int|null $hide
 * @property string|null $renew
 * @property Carbon|null $lastcheck
 * @property string|null $changed
 * @property int|null $nevercustomer
 * @property string|null $ourgodaddy
 * @property string|null $thenote
 * @property string|null $registration_status
 * @property int|null $rechecked
 * @property string|null $secondary
 * @property string|null $mastiffip
 * @property int|null $needfix
 * @property string|null $in_conf
 * @property string|null $htaccess
 * @property string|null $wpe_update
 * @property string|null $constellix
 * @property int|null $constellix_id
 * @property string|null $zone_template
 * @property string|null $updatestatus
 * @property string|null $time
 * @property int|null $using_prs
 * @property int|null $is_expired
 * @property string|null $us_only
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property Practice|null $practice
 *
 * @package App\Models
 */
class Domain extends Model
{
	protected $table = 'domain';

	protected $casts = [
		'practice_id' => 'int',
		'statuscake' => 'int',
		'emails' => 'int',
		'emailchecked' => 'int',
		'hide' => 'int',
		'lastcheck' => 'datetime',
		'nevercustomer' => 'int',
		'rechecked' => 'int',
		'needfix' => 'int',
		'constellix_id' => 'int',
		'using_prs' => 'int',
		'is_expired' => 'int'
	];

	protected $fillable = [
		'practice_id',
		'domain',
		'monitor',
		'statuscake',
		'emails',
		'emailchecked',
		'wwwip',
		'ip',
		'ns',
		'mx',
		'registrar',
		'hide',
		'renew',
		'lastcheck',
		'changed',
		'nevercustomer',
		'ourgodaddy',
		'thenote',
		'registration_status',
		'rechecked',
		'secondary',
		'mastiffip',
		'needfix',
		'in_conf',
		'htaccess',
		'wpe_update',
		'constellix',
		'constellix_id',
		'zone_template',
		'updatestatus',
		'time',
		'using_prs',
		'is_expired',
		'us_only'
	];

	public function practice()
	{
		return $this->belongsTo(Practice::class);
	}
}
