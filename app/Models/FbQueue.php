<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FbQueue
 *
 * @property int $id
 * @property int|null $practice_id
 * @property int|null $news_id
 * @property string|null $status
 * @property Carbon|null $dt_added
 * @property Carbon|null $dt_start
 * @property Carbon|null $dt_finish
 * @property string|null $result
 * @property int|null $remove
 * @property string|null $new_page_experience
 * @property string|null $news_item_type
 *
 * @package App\Models
 */
class FbQueue extends Model
{
	protected $table = 'fb_queue';
	public $timestamps = false;

	protected $casts = [
		'practice_id' => 'int',
		'news_id' => 'int',
		'dt_added' => 'datetime',
		'dt_start' => 'datetime',
		'dt_finish' => 'datetime',
		'remove' => 'int'
	];

	protected $fillable = [
		'practice_id',
		'news_id',
		'status',
		'dt_added',
		'dt_start',
		'dt_finish',
		'result',
		'remove',
		'new_page_experience',
		'news_item_type'
	];

    public function practice()
    {
        return $this->belongsTo(Practice::class,'practice_id');
    }
}
