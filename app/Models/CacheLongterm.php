<?php

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * this model is responsible to store cache value for a long time of period
 * it's just update the value rather then deleting it
 * Class CacheLongterm
 * @package App\Models
 */
class CacheLongterm extends AcpPracticeModel
{
    /**
     * @var string[] column for allow mass assignment
     */
    protected $fillable = ['cache_key','cache_value','cache_range','expiration','practice_id'];
    /**
     * @var string[] the actual cache value that store in json format
     */
    protected $casts = [
        'cache_value'=>'json',
    ];

    /**
     * this scope return only current practice related cache data
     * @param object $query
     * @param string $key unique string for cache
     */
    public function scopeOnlyMyPracticeCache($query, $key=null, $practiceId=null)
    {
        $query->OnlyMyPractice($practiceId)
            ->when($key!=null,function ($q) use ($key){
                $q->where('cache_key',$key);
            });
    }
    /**
     * this scope return after applying search & short
     * @param object $query
     * @param string $key
     * @param string $sortField
     * @param string $sortAsc
     */
    public function scopeSearchCacheKey($query, $key,$sortField,$sortAsc)
    {
        $query->where('cache_key', 'like', "%$key%")
            ->orderBy($sortField, $sortAsc);
    }

    /**
     * @param $query
     * @param $month
     * @param $year
     */
//  public function scopeUpdatedInMonth($query, $month, $year)
//  {
//    $query->whereMonth('updated_at',$month)->whereYear('updated_at',$year);
//  }

    /**
     * @param $practiceId
     * @return int|void
     */
    static function shortTermCacheClean($practiceId)
    {
        $surveyID = Practice::find($practiceId)->survey->ID ?? null;
        if ($surveyID){
            return ShortTermCache::where('key', 'like', '%\_'.$practiceId)
                ->orWhere('key', 'like', '%'.$surveyID)->delete();
        }
        ShortTermCache::where('key', 'like', '%\_'.app('the-practice')->survey->ID)->get();
    }

    /**
     * this function simply remove cache data that for the current practice
     * @param $practiceId Laravel Specific code, practiceId is required in non-laravel
     */
    static function cacheClean($practiceId =null)
    {
        $practiceId = $practiceId ?? app('the-practice')->practice_id;
        static::shortTermCacheClean($practiceId);
        Static::where('practice_id',$practiceId)->delete();
    }

    /**
     * @param $practiceId
     * @return \Illuminate\Support\Collection
     */
    static function shortTermCacheData($practiceId)
    {
        return ShortTermCache::select('key','value')->where('key', 'like', '%\_'.$practiceId)
            ->where('expiration', '>', Carbon::now()->timestamp)->pluck('value','key');
    }

    /**
     * get all data that expiration time is higher than current time
     * @param $practiceId Laravel Specific code, practiceId is required in non-laravel
     * @return mixed
     */
    static function longTermCacheData($practiceId=null)
    {
        $practiceId = $practiceId ?? app('the-practice')->practice_id;
        return Static::select('cache_key','cache_value')->where("practice_id",$practiceId)
            ->where('expiration', '>', Carbon::now()->timestamp)->pluck('cache_value','cache_key');
    }

    /**
     * @param string $key
     * @param null $practiceId Laravel Specific code, practiceId is required in non-laravel
     * @param $sortField
     * @param $sortAsc
     * @return \Illuminate\Database\Query\Builder
     */
    static function shortTermAllCacheData($key="", $practiceId=null, $sortField, $sortAsc)
    {
        $practiceId = $practiceId ?? app('the-practice')->practice_id;
        return ShortTermCache::where('key', 'like', '%\_'.$practiceId)
            ->where('key', 'like', "%$key%")
            ->orderBy($sortField, $sortAsc);
    }

    /**
     * delete short time cache
     * @param $key
     * @return boolean true|false
     */
    static function deleteShortTerm($key)
    {
        ShortTermCache::where('key', $key)->delete();
        return true;
    }

    public function practice() {
        return $this->belongsTo(Practice::class, 'practice_id' );
    }

}
