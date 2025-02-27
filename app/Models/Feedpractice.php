<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedpractice extends Model
{
    protected $table = 'feed_practice';
    public $timestamps = false;
    protected $primaryKey = 'practice_id';

    /**
     * for checking practice has accessibility to use feed
     * @return bool
     */
    public function getIsFeedAccessibleAttribute()
    {
        return strtolower($this->use_feed) == 'yes';
    }
    public function practice() {
        return $this->belongsTo(Practice::class, 'practice_id' );
    }
}
