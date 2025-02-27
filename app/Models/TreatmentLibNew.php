<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TreatmentLibNew extends Model
{
  protected $table = 'treatment_lib_new';
  public $timestamps = false;

  public function library()
  {
    return $this->belongsTo(Library::class,'lib_id','ID');
  }
}
