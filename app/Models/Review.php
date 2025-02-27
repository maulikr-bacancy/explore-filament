<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

class Review extends AcpPracticeModel
{
    protected $table = 'reviews';

    public $timestamps = false;

    /**
     * Mass assignable columns
     */
    protected $fillable = [
//    'facebook_published',
//    'practice_id',
        'erehab_status',
        'createdate',
        'original_review',
        'edited_review',
        'signature',
        'status',
        'viewed',
        'patname',
        'patname_ssl',
        'stars',
        'location',
//    'location_id',
        'email',
        'email_ssl',
        'sample',
        'theme',
        'seen',
        'last_seen',
        'phone',
        'action',
        'rep_date',
        'prs_level',
        'from_rep',
        'from_dash',
        'is_from_info',
        'img_location',
        'img_release_date',
        'video_script_ver',
        'video_process_status',
        'video_process_date',
        'video_release_date',
//    'video_youtube_id',
        'video_youtube_uploaded',
        'output_type',
        'output_date',
        'recommended_output',
        'facebook_published'];

    /**
     * Date time columns.
     */
    protected $casts = [
        'createdate' => 'datetime',
        'img_release_date' => 'datetime',
        'video_process_date' => 'datetime',
        'video_release_date' => 'datetime',
        'video_youtube_uploaded' => 'datetime',
        'output_date' => 'datetime',
        'facebook_published' => 'datetime'
    ];

    /**
     * Laravel Specific code
     * @param $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /**
     * Laravel Specific code
     * @param $value
     * @return string
     */
    public function getPatnameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

// todo need to remove - not used any where
//  public static function findReviews($query = '',$practiceId=null)
//  {
//    $practiceId = $practiceId ?? app('the-practice')->practice_id;
//    $pid = static::where('practice_id', $practiceId);
//    return empty($query) ? $pid : $pid->where('patname', 'like', "%$query%");
//  }

    /**
     * @param $practiceId Laravel Specific code, practiceId is required in non-laravel
     * @return mixed
     */
    public static function countWithMonth($practiceId = null)
    {
        $practiceId = $practiceId ?? app('the-practice')->practice_id;
        return static::selectRaw('count(id) as total, DATE_FORMAT(createdate,"%Y-%m") as yearMonth')
            ->OnlyMyPractice($practiceId)
            ->groupBy('yearMonth');
    }

    /**
     * @param $practiceId
     * @return mixed
     */
    public static function countWithDate($practiceId)
    {
        return static::selectRaw('count(id) as total,DATE_FORMAT(createdate,"%Y-%m-%d") as date')
            ->OnlyMyPractice($practiceId)
            ->latest('date')->groupBy('date');
    }

    /**
     * @param $query
     * @param $type
     * @return void
     */
    public function scopeCurrentMonthData($query, $type = '')
    {
        $date = Carbon::now();
        $query->when($type == 'monthly', function ($query) use ($date) {
            return $query->havingRaw('Month(date) = ' . $date->month)->havingRaw('YEAR(date) = ' . $date->year);
        }, function ($query) use ($date) {
            return $query->havingRaw('Month(concat(yearMonth,"-01")) = ' . $date->month)->havingRaw('YEAR(concat(yearMonth,"-01")) = ' . $date->year);
        });
    }

    /**
     * @param $query
     * @param $type
     * @return void
     */
    public function scopePastMonthData($query, $type = '')
    {
        $date = Carbon::parse('first day of this month')->subMonths(7)->format('Y-m-d');
        $query->when($type == 'monthly', function ($query) use ($date) {
            return $query->havingRaw('date < "' . $date . '"');
        }, function ($query) use ($date) {
            $query->havingRaw('concat(yearMonth,"-01") < "' . $date . '"');
        });
    }

    /**
     * @param $query
     * @param $type
     * @param $year
     * @return void
     */
    public function scopeOnlyYearAgo($query, $type = '', $year)
    {
        $date = Carbon::now()->subYear($year)->startOfYear()->format('Y-m-d');
        $query->when($type == 'monthly', function ($query) use ($date) {
            return $query->havingRaw('date > "' . $date . '"');
        }, function ($query) use ($date) {
            $query->havingRaw('concat(yearMonth,"-01") > "' . $date . '"');
        });
    }

    /**
     * Get the practice associated with the review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function practice() {
        return $this->belongsTo( Practice::class, 'practice_id' );
    }
}
