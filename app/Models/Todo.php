<?php

namespace App\Models;

class Todo extends AcpPracticeModel
{
  /**
   * @var string $table name
   * @var bool $timestamp for store created_at & updated_at time
   */
  protected $table = 'todo';
  protected $primaryKey = 'todo';
  public $timestamps = false;

  public function scopeOnlyErehabItems($query){
    $query->where('erehab_item',1);
  }

  public function scopeOnlyErehabDone($query){
    $query->where('erehab_done',1);
  }
}
