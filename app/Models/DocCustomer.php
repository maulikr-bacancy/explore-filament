<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocCustomer
 *
 * @property int $id
 * @property int|null $doc_id
 * @property int|null $practice_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DocCustomer extends Model
{
	protected $table = 'doc_customer';

	protected $casts = [
		'doc_id' => 'int',
		'practice_id' => 'int'
	];

	protected $fillable = [
		'doc_id',
		'practice_id'
	];

    public function practice() {
        return $this->belongsTo( Practice::class,'practice_id');
    }
}
