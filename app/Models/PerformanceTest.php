<?php
namespace App\Models;

class PerformanceTest extends AcpPracticeModel
{
  protected $guarded = [];

  protected $casts = [
    'date_of_test' => 'datetime:Y-m-d'
  ];

  public function problemType()
  {
    return $this->belongsToMany(PerformanceProblemType::class, PerformanceProblemLink::class,'test_id','problem_type_id')
      ->withPivot('id','notes','status','who_working_on','todo_id','problem_type_id');
  }

  public function runBy(){
    return $this->hasOne(Security::class,'sec_id','who_ran_test');
  }

  public function practice()
  {
    return $this->hasOne(Practice::class,'ID','practice_id');
  }

}
