<?php

namespace App\Models;

use Carbon\Carbon;

/**
 *
 */
class Broadcast extends AcpPracticeModel
{
  /**
   * @var string $table name
   * @var string $primaryKey
   * @var bool $timestamp for store created_at & updated_at time
   */
  protected $table = 'newslettersforcustomers';
  protected $primaryKey = 'ID';
  public $timestamps = false;
  /**
   * @var string[] all column for allow mass assignment
   */
  protected $fillable = ['Name','subject','Content'];

  /**
   * @return void set month,year and Number in create event
   */
  public static function boot()
  {
    parent::boot();
    static::creating(function ($model) {
      $now = Carbon::now();
      $model->month = $now->month;
      $model->year = $now->year;
    });
    static::created(function ($model) {
      if (is_null($model->Type) || $model->Type=="Broadcast") {
        $model->number = $model->ID;
        $model->save();
      }
    });
  }

  /**
   * @param $query
   * @param $type
   * @return void
   */
  public static function scopeIgnoreTypes($query, $type)
  {
    $query->whereNotIn('type', $type);
  }

  /**
   * @param $newsletterID
   * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
   * @return Broadcast
   */
  public static function GetBroadcastNL($newsletterID, $practiceId=null){
    $broadcast = Broadcast::where('number',$newsletterID)->OnlyMyPractice($practiceId)->first();
    if ($broadcast){
      return $broadcast;
    }
    $newsLetter = Newsletter::findOrFail($newsletterID);
    $broadcast = new Broadcast();
    $broadcast->number = $newsletterID;
    $broadcast->Type = $newsLetter->Type;
    $broadcast->Content = $newsLetter->Content;
    $broadcast->htmlTemplate = $newsLetter->htmlTemplate;
    $broadcast->subject = $newsLetter->broadcastsubject;
    $broadcast->Name = $newsLetter->Name;
    $broadcast->month = $newsLetter->month;
    $broadcast->year = $newsLetter->year;
    $broadcast->customertype = $newsLetter->customertype;
    $broadcast->practice_id = $practiceId ?? app('the-practice')->practice_id;
    $broadcast->save();
    return $broadcast;
  }
}
