<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GCity
 *
 * @property int $id
 * @property int $practice_id
 * @property string $city
 * @property int|null $display_order
 * @property string|null $service
 * @property int|null $template
 * @property string|null $settings
 * @property string|null $wordpress
 * @property int|null $wp_page_id
 * @property Carbon|null $last_edit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class GCity extends Model
{
	protected $table = 'g_cities';

	protected $casts = [
		'practice_id' => 'int',
		'display_order' => 'int',
		'template' => 'int',
		'wp_page_id' => 'int',
		'last_edit' => 'datetime'
	];

	protected $fillable = [
		'practice_id',
		'city',
		'display_order',
		'service',
		'template',
		'settings',
		'wordpress',
		'wp_page_id',
		'last_edit'
	];

    public function practice()
    {
        return $this->belongsTo(\App\Models\Practice::class, 'practice_id');
    }
}
