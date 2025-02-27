<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  protected $table = 'news';
  public $timestamps = false;
  protected $casts = ['datecreated' => 'datetime'];

  public function getReleaseDateAttribute()
  {
    return $this->datecreated ? $this->datecreated->format('M j, Y') : '';
  }

  public function tags(){
    return $this->belongsToMany(Tag::class,'newstag','newsid','tag');
  }
}
