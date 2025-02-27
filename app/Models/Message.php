<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property varchar $scope scope
 * @property timestamp $createdate createdate
 * @property varchar $title title
 * @property text $msg msg
 * @property varchar $summary summary
 * @property varchar $exclude exclude
 * @property varchar $sentby sentby
 * @property varchar $hide hide
 * @property date $expire expire
 */
class Message extends Model
{

  protected $table = 'messages';
  public $timestamps = false;
  protected $fillable = ['expire',
    'scope',
    'createdate',
    'title',
    'msg',
    'summary',
    'exclude',
    'sentby',
    'hide',
    'expire'];

  /**
   * Date time columns.
   */
  protected $casts = [
    'createdate' => 'datetime',
    'expire' => 'datetime'
  ];


  /**
   * Laravel Specific code
   * @return array|string|string[]|null
   */
  public function getMessageAttribute(){
    $practice = app('the-practice');
    $patterns = array();
    $patterns[0] = '/{!ID!}/';
    $patterns[1] = '/{!website!}/';
    $patterns[2] = '/{!Name!}/';
    $replacements = array();
    $replacements[0] = $practice->ID;
    $replacements[1] = $practice->website;
    $replacements[2] = $practice->Name;
    return preg_replace($patterns, $replacements, $this->msg);
  }

  /**
   * Laravel Specific code
   * @return int
   */
  public function getReadAttribute(){
    return in_array($this->id,app('the-practice')->readMessages()->toArray()) ? 1 : 0;
  }

  /**
   * Laravel Specific code
   * @return void
   */
  public function setReadAttribute(){
    DB::table('messagesread')
      ->updateOrInsert(
        ['practice_id' => app('the-practice')->model->ID, 'msgid' => $this->id],
        ['practice_id' => app('the-practice')->model->ID, 'msgid' => $this->id]
      );
  }

  /**
   * Scope a query to only include users of a given type.
   * Laravel Specific code
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param  mixed  $alreadyRead
   * @return \Illuminate\Database\Eloquent\Builder
   */

  public function scopeAllUnread($query)
  {
    $practice=app('the-practice');
    return $query->where('hide','!=','True')->where('expire','>',date('Y-m-d'))->whereNotIn('id',$practice->readMessages());
  }

  /**
   * @param $query
   * @return mixed
   */
  public function scopeAllMessages($query)
  {
    return $query->where('hide','!=','True')->where('expire','>',date('Y-m-d'));
  }





}
