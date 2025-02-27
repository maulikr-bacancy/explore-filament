<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Json;

/**
 * this is for setting related thing in acp
 */
class AcpSetting extends Model
{
    /**
     * @var string[] $fillable column for allow mass assignment
     * @var string[] $casts casts setting column
     */
    protected $fillable = ['setting','key','practice_id','user_id'];
    protected $casts = [
        'setting'=>'json'
    ];

    /**
     * @param $query
     * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
     * @param $key
     * @return void
     */
    public function scopeOnlyPracticeSetting($query, $practiceId = null, $key = null)
    {
        // Laravel specific code app() is available in laravel
        $query->where([
            'practice_id' => $practiceId ?? app('the-practice')->practice_id,
            'user_id' => null
        ])->when($key != null, function ($query) use($key) {
            return $query->where('key',$key);
        });
    }

    /**
     * @param $string
     * @return string
     */
    public  static function encodeSetting($string)
    {
        return trim(str_replace(['?','/',',',':',"'",' '],['$_1','$_2','$_3','$_4','$_5','_'],$string));
    }

    /**
     * @param $string
     * @return array|string|string[]
     */
    public  static function decodeSetting($string)
    {
        return str_replace(['$_1','$_2','$_3','$_4','$_5','_'], ['?','/',',',':',"'",' '], $string);
    }

    /**
     * @param $setting
     * @param $overwrittenArray
     * @return array
     */
    public static function chartWithOverwrite($setting, $overwrittenArray)
    {
        if ($setting)
        {
            $commonChart = array_intersect_key($setting,$overwrittenArray);
            $newlyAddedConstants = array_diff_key($overwrittenArray,$setting);
            $charts = array_merge($commonChart,$newlyAddedConstants);
            ksort($charts);
            return $charts;
        }
        ksort($overwrittenArray);
        return $overwrittenArray ?? [];
    }

    /**
     * @param $key
     * @param $practice_id || Laravel Specific code, practiceId is required in non-laravel
     * @param $user_id || Laravel Specific code, user_id is required in non-laravel
     * @return array
     */
    public static function getSetting($key=null, $practice_id=null, $user_id=null)
    {
        if ($key){
            $setting = Static::select('setting')->where([
                'practice_id'=> $practice_id ?? app('the-practice')->practice_id,
                'user_id' => $user_id ?? auth()->id(),
                'key' => $key
            ])->first();
            return $setting->setting ?? [];
        }
        return Static::select('setting','key')->where([
            'practice_id'=> $practice_id ?? app('the-practice')->practice_id,
            'user_id' => $user_id ?? auth()->id()
        ])->get();
    }

    /**
     * @param $practiceId
     * @return mixed
     */
    public static function getGoogleReviewStartDate($practiceId=null){
        $practiceSetting = static::select('setting')->OnlyPracticeSetting($practiceId,'practice_setting')->first();
        return $practiceSetting->setting['google_review_start_date'] ?? config('constants.default.google_review_start_date');
    }

    /**
     * @param $practiceId
     * @param $date
     * @return mixed
     */
    public static function saveGoogleReviewStartDate($practiceId, $date){
        $setting = Static::firstOrNew([
            'practice_id'=> $practiceId,
            'key' => 'practice_setting',
            'user_id' => null
        ]);
        $acpSetting = $setting->setting;
        $acpSetting['google_review_start_date'] = $date;
        $setting->setting = $acpSetting;
        return $setting->save();
    }

    /**
     * @param string $key
     * @param Json $data
     * @param int|null $practice_id || Laravel Specific code, practiceId is required in non-laravel
     * @param int|null $user_id || Laravel Specific code, user_id is required in non-laravel
     * @return void
     */
    public static function saveSetting($key, $data, $practice_id=null, $user_id=null)
    {
        $setting = static::firstOrNew([
            'practice_id'=> $practice_id ?? app('the-practice')->practice_id,
            'user_id' => $user_id ?? auth()->id(),
            'key' => $key
        ]);
        $setting->setting = $data;
        $setting->practice_id = $practice_id ?? app('the-practice')->practice_id;
        $setting->user_id = $user_id ?? auth()->id();
        $setting->save();
    }

    /**
     * Get the practice related to the acpSetting
     */
    public function practice()
    {
        return $this->belongsTo('App\Models\Practice', 'practice_id');
    }

    /**
     * Get the clinic related to the acpSetting
     */
    public function clinic()
    {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id');
    }
    /**
     * Get the user related to the acpSetting
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
