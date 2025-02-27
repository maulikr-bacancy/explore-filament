<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsForPractice extends Model
{
  protected $table = "news_for_practice";
  protected $casts = ['distribution_time'=>'datetime'];

  protected static function boot()
  {

    parent::boot();

    // updating created_by and updated_by when model is created
    static::creating(function ($model) {
      if (!$model->isDirty('created_by')) {
        $model->created_by = auth()->user()->id;
      }
      if (!$model->isDirty('updated_by')) {
        $model->updated_by = auth()->user()->id;
      }
      // auto assign practice id when new news created
      $model->practice_id = app('the-practice')->practice_id;
    });

    // updating updated_by when model is updated
    static::updating(function ($model) {
      if (!$model->isDirty('updated_by')) {
        $model->updated_by = auth()->user()->id;
      }
    });
  }

  public function getReleaseDateAttribute()
  {
    return $this->distribution_time ? $this->distribution_time->format('M j, Y') : '';
  }

  public function tags(){
    return $this->belongsToMany(Tag::class,'news_for_practice_tag','news_for_practice_id','tag_id');
  }
}
