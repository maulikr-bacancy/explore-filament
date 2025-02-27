<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Canada
 *
 * @property int $practice_id
 *
 * @package App\Models
 */
class Canada extends Model
{
    protected $table = 'canada';
    protected $primaryKey = 'practice_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'practice_id' => 'int'
    ];

    public function practice() {
        return $this->belongsTo( Practice::class,'practice_id');
    }
}
