<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Host
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $ip
 * @property string|null $primary_theme
 * @property string|null $provider
 * @property string|null $login_url
 * @property string|null $ftp_settings
 * @property string|null $wp_admin_email
 * @property int|null $primary_tech
 * @property int|null $manager
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Host extends Model
{
	protected $table = 'hosts';

	protected $casts = [
		'primary_tech' => 'int',
		'manager' => 'int'
	];

	protected $fillable = [
		'name',
		'ip',
		'primary_theme',
		'provider',
		'login_url',
		'ftp_settings',
		'wp_admin_email',
		'primary_tech',
		'manager'
	];
	//		HasMany Tables======================================================
	public function oldHydra() {
		return $this->hasMany( Appointment::class, 'old_host_id' );
	}
	public function newHydra() {
		return $this->hasMany( Appointment::class, 'new_host_id' );
	}
	
	// Belongs To Tables========================================================
	public function manager() {
		return $this->belongsTo(security::class, 'manager' );
	}
	
	public function primary() {
		return $this->belongsTo(security::class, 'primary' );
	}
}
