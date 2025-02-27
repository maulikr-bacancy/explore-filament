<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * this is the common model for AcpPractice so most common method define here
 */
class AcpPracticeModel extends Model
{
  protected $practiceKey = 'practice_id';

    protected static function booted()
    {
      static::addGlobalScope('only_my_practice', function ($builder) {
        $practiceId = app('the-practice')->practice_id ?? null;
          if ($practiceId) {
             $builder->where((new static())->practiceKey, $practiceId);
          }
      });
    }

/**
   * Scope a query to only include specific practice
   * @param $query
   * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
   * @return void
   */
  public function scopeOnlyMyPractice($query, $practiceId=null)
  {
    // Laravel specific code app() is available in laravel
    $practiceId = $practiceId ?? app('the-practice')->practice_id;
    $query->where($this->practiceKey,$practiceId);
  }

  /**
   * Scope a query to only include specific type
   * @param $query
   * @param $type
   * @return void
   */
  public static function scopeType($query, $type)
  {
    $query->where('type',$type);
  }


  public static function scopeSearchName($query,$search)
  {
    $query->where('name','like','%' .$search.'%');
  }
}
