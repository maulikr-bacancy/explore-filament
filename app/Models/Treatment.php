<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
  protected $table = 'treatment';
  public $timestamps = false;

  /**
   * Get the lib for the blog treatment.
   */
  public function lib()
  {
    return $this->hasMany(TreatmentLib::class);
  }
}
