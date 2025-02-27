<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Faq
 * 
 * @property int $id
 * @property string|null $title
 * @property string $content
 * @property int $sort_order
 * @property int $display
 *
 * @package App\Models
 */
class Faq extends Model
{
	protected $table = 'faq';
	public $timestamps = false;

	protected $casts = [
		'sort_order' => 'int',
		'display' => 'int'
	];

	protected $fillable = [
		'title',
		'content',
		'sort_order',
		'display'
	];
}
