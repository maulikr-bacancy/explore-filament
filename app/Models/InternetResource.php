<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternetResource extends Model
{
  protected $table = 'internet_resource';
  public $timestamps = false;

  public function practice()
  {
	  return $this->belongsTo(Practice::class, 'practice_id')->where('location_id', '=', 'all');
  }

  public function clinic()
  {
	  return $this->belongsTo(Clinic::class, 'location_id')->where('location_id', '!=', 'all');
  }

  public function notes()
  {
    return $this->hasMany(InternetResourceNotes::class,'ir_id','id');
  }

  //Scop function

  public function scopeLocalSEO($query,$status='true')
  {
    $query->where('localseo',$status);
  }
}
