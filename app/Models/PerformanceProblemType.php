<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PerformanceProblemType extends Pivot
{
  protected $table = "performance_problem_types";

  public function performanceTest()
  {
    return $this->belongsToMany(PerformanceTest::class, PerformanceProblemLink::class,'problem_type_id','test_id')->withPivot('id');
  }
}
