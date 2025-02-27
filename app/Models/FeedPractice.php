<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeedPractice
 *
 * @property int $practice_id
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $link
 * @property string|null $author
 * @property string|null $description
 * @property string|null $active
 * @property string|null $code
 * @property int|null $show_mss
 * @property int|null $show_holiday
 * @property int|null $show_humor
 * @property int|null $show_tip
 * @property int|null $show_recipe
 * @property int|null $show_meme
 * @property int|null $show_newsletter
 * @property string|null $use_feed
 * @property Carbon|null $last_feed_check
 * @property Carbon|null $last_feed_send
 * @property int|null $send_time
 * @property int|null $parent_practice_id
 * @property string|null $facebookid
 * @property string|null $facebookurl
 * @property Carbon|null $token_date
 * @property string|null $page_access_token
 * @property int|null $broken_count
 * @property Carbon|null $last_break
 * @property Carbon|null $access_date
 * @property string|null $agency_access
 * @property int|null $new_page_experience
 * @property Carbon|null $npe_found
 *
 * @package App\Models
 */
class FeedPractice extends Model
{
	protected $table = 'feed_practice';
	protected $primaryKey = 'practice_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'practice_id' => 'int',
		'show_mss' => 'int',
		'show_holiday' => 'int',
		'show_humor' => 'int',
		'show_tip' => 'int',
		'show_recipe' => 'int',
		'show_meme' => 'int',
		'show_newsletter' => 'int',
		'last_feed_check' => 'datetime',
		'last_feed_send' => 'datetime',
		'send_time' => 'int',
		'parent_practice_id' => 'int',
		'token_date' => 'datetime',
		'broken_count' => 'int',
		'last_break' => 'datetime',
		'access_date' => 'datetime',
		'new_page_experience' => 'int',
		'npe_found' => 'datetime'
	];

	protected $hidden = [
		'page_access_token'
	];

	protected $fillable = [
		'title',
		'subtitle',
		'link',
		'author',
		'description',
		'active',
		'code',
		'show_mss',
		'show_holiday',
		'show_humor',
		'show_tip',
		'show_recipe',
		'show_meme',
		'show_newsletter',
		'use_feed',
		'last_feed_check',
		'last_feed_send',
		'send_time',
		'parent_practice_id',
		'facebookid',
		'facebookurl',
		'token_date',
		'page_access_token',
		'broken_count',
		'last_break',
		'access_date',
		'agency_access',
		'new_page_experience',
		'npe_found'
	];
}
