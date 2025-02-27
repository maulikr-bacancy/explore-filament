<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banned
 *
 * @property int $ID
 * @property int $practiceID
 * @property string $state
 *
 * @package App\Models
 */
class Banned extends Model
{
	protected $table = 'banned';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'practiceID' => 'int'
	];

	protected $fillable = [
		'practiceID',
		'state'
	];

    /**
     * Get the practice related to the banned
     */
    public function practice()
    {
        return $this->belongsTo('App\Models\Practice', 'practiceID');
    }
}
