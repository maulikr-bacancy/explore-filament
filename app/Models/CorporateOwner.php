<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $practice_id
 * @property string $name
 */
class CorporateOwner extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['practice_id', 'name'];
}
