<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

/**
 * for track the user's usages
 */
class AcpWhoUsage extends Model
{
  use HasFactory;

  /**
   * @var string[] $fillable column for allow mass assignment
   * @var string[] $casts casts acp_page_visits column to array
   */
  protected $fillable = ['last_login','practice_id','user_id'];
  protected $casts = ['acp_page_visits' => 'array'];

  /**
   * increment switch_practice count if user switch practice
   * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
   * @param $user_id || Laravel Specific code, user_id is required in non-laravel
   * @return void
   */
  public static function trackPracticeSwitch($practiceId=null, $user_id=null)
  {
    $practiceId = $practiceId ?? app('the-practice')->practice_id;
    $user_id = $user_id ?? Auth::user()->id;
    $whoUsage = AcpWhoUsage::firstOrNew([
        'practice_id'=> $practiceId,
        'user_id'=>$user_id
    ]);
    $whoUsage->user_id = $user_id;
    $whoUsage->practice_id = $practiceId;
    $whoUsage->last_login = Carbon::now();
    $acp_page_visits = $whoUsage->acp_page_visits;
    $acp_page_visits['switch_practice'] =isset($acp_page_visits['switch_practice']) ? $acp_page_visits['switch_practice']+1 : 1;
    $whoUsage->acp_page_visits = $acp_page_visits;
    return $whoUsage->save();
  }

  /**
   * increment subscribers_added count when user add subscriber
   * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
   * @param $user_id || Laravel Specific code, user_id is required in non-laravel
   * @return void
   */
  public static function incrementSubscriber($practiceId=null, $user_id=null)
  {
    $practiceId = $practiceId ?? app('the-practice')->practice_id;
    $user_id = $user_id ?? Auth::user()->id;
    $whoUsage = AcpWhoUsage::firstOrNew([
        'practice_id'=>$practiceId,
        'user_id'=>$user_id
    ]);
    $whoUsage->practice_id = $practiceId;
    $whoUsage->user_id = $user_id;
    $whoUsage->increment('subscribers_added');
    $whoUsage->save();
  }

  /**
   * get user || Laravel specific code
   * @return mixed
   */
  public function user()
  {
    return $this->hasOne(User::class,'id','user_id');
  }

  /**
   * return related practice if any
   * @return mixed
   */
  public function practice()
  {
    return $this->hasOne(Practice::class,'ID','practice_id');
  }
}
