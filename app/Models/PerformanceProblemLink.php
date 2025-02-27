<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceProblemLink extends Model
{
  protected $guarded = [];

  public function scopeTestId($query,$test_id){
    $query->where('test_id',$test_id);
  }
  public function scopeProblemType($query,$type_id){
    $query->where('problem_type_id',$type_id);
  }

  public function performanceTest() {
    return $this->belongsTo(PerformanceTest::class,'test_id');
  }

  public function performanceProblemType() {
    return $this->belongsTo(PerformanceProblemType::class,'problem_type_id');
  }
}
