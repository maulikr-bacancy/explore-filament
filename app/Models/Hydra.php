<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Hydra
 *
 * @property int $id
 * @property int $practice_id
 * @property string|null $status
 * @property int|null $order
 * @property int|null $priority
 * @property Carbon|null $started_at
 * @property Carbon|null $end_target
 * @property Carbon|null $closed
 * @property Carbon|null $qa_check
 * @property int|null $old_host_id
 * @property int|null $new_host_id
 * @property string|null $theme_old
 * @property string|null $theme_new
 * @property int|null $manager
 * @property int|null $primary
 * @property int|null $qa_checker
 * @property string|null $old_performance
 * @property string|null $new_performance
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class Hydra extends Model
{
	protected $table = 'hydra';

	protected $casts = [
		'practice_id' => 'int',
		'order' => 'int',
		'priority' => 'int',
		'started_at' => 'datetime:M d, Y',
		'end_target' => 'datetime:M d, Y',
		'closed_at' => 'datetime:M d, Y',
		'qa_check_at' => 'datetime:M d, Y',
		'old_host_id' => 'int',
		'new_host_id' => 'int',
		'new_blog_id' => 'int',
		'manager' => 'int',
		'primary' => 'int',
		'qa_checker' => 'int'
	];

	protected $fillable = [
		'practice_id',
		'status',
		'order',
		'priority',
		'started_at',
		'end_target',
		'closed_at',
		'qa_check_at',
		'old_host_id',
		'new_host_id',
		'new_blog_id',
		'theme_old',
		'theme_new',
		'old_performance',
		'new_performance',
		'manager_id',
		'primary_id',
		'qa_checker_id',
		'note'
	];
	
	public function practice() {
		return $this->belongsTo(Practice::class, 'practice_id' );
	}
	
	public function oldHost() {
		return $this->belongsTo(Host::class, 'old_host_id' );
	}
	public function newHost() {
		return $this->belongsTo(Host::class, 'new_host_id' );
	}
	
	public function manager() {
		return $this->belongsTo(Security::class, 'manager_id' );
	}
	
	public function primary() {
		return $this->belongsTo(Security::class, 'primary_id' );
	}
	public function qaChecker() {
		return $this->belongsTo(Security::class, 'qa_checker_id' );
	}
	
	
	public function scopeActive( $query ) {
		return $query->whereHas( 'practice', function ( $query ) {
			$query->where( 'in_count', 1 );
		} );
	}
	
	
	
}
