<?php
namespace App\Models;

use Carbon\Carbon;
class GoogleReview extends AcpPracticeModel
{
    const PULLED_TYPE_UNKNOWN='unknown';

    const PULLED_TYPE_MANUAL='manual';

    const PULLED_TYPE_WEBHOOK='webhook';

    const PULLED_TYPE_AUTOFIX='autofix';

    const PULLED_TYPE_ID_UPDATE='id_update';

    const ACKNOWLEDGED_FOUND='found';

    const ACKNOWLEDGED_NOTIFIED='notified';

    const ACKNOWLEDGED_DONE='done';

    const STAR_RATING_ONE='ONE';

    const STAR_RATING_TWO='TWO';

    const STAR_RATING_THREE='THREE';

    const STAR_RATING_FOUR='FOUR';

    const STAR_RATING_FIVE='FIVE';

    /**
     * Database table name
     */
    protected $table = 'google_reviews';

    /**
     * Mass assignable columns
     */
    protected $fillable=['id_update_time',
//    'review_id',
//    'review_id_v2',
//    'clinic_id',
        'location',
//    'practice_id',
//    'google_location_id',
        'reviewer_display_name',
        'star_rating',
        'comment',
        'create_time',
        'update_time',
        'reviewer_is_anonymous',
        'review_reply_comment',
        'review_reply_update_time',
        'display',
        'acknowledged',
        'pulled_time',
        'pulled_type',
        'id_update_time'];

    /**
     * Date time columns.
     */
    protected $casts = [
        'create_time' => 'datetime',
        'update_time' => 'datetime',
        'review_reply_update_time' => 'datetime',
        'pulled_time' => 'datetime',
        'id_update_time' => 'datetime'
    ];
    public $timestamps = false;


    public static function countWithDate($practiceId)
    {
        return static::selectRaw('count(id) as total,DATE_FORMAT(create_time,"%Y-%m-%d") as date')
            ->OnlyMyPractice($practiceId)
            ->latest('date')->groupBy('date');
    }

    /**
     * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
     * @return mixed
     */
    public static function countWithMonth($practiceId = null)
    {
        $practiceId = $practiceId ?? app('the-practice')->practice_id;
        return static::selectRaw('count(id) as total, DATE_FORMAT(create_time,"%Y-%m") as yearMonth')
            ->OnlyMyPractice($practiceId)
            ->groupBy('yearMonth');
    }

    public function scopePastMonthData($query, $type = '')
    {
        $date = Carbon::parse('first day of this month')->format('Y-m-d');
        $query->when($type == 'monthly', function ($query) use ($date) {
            return $query->havingRaw('date < "' . $date . '"');
        }, function ($query) use ($date) {
            $query->havingRaw('concat(yearMonth,"-01") < "' . $date . '"');
        });
    }
    public function scopeOnlyYearAgo($query, $type = '',$year)
    {
        $date = Carbon::now()->subYear($year)->startOfYear()->format('Y-m-d');
        $query->when($type == 'monthly', function ($query) use ($date) {
            return $query->havingRaw('date > "' . $date . '"');
        }, function ($query) use ($date) {
            $query->havingRaw('concat(yearMonth,"-01") > "' . $date . '"');
        });
    }
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
     * @param $practiceID || Laravel Specific code, practiceId is required in non-laravel
     * @return int|mixed
     */
    public static function countByClinic($practiceID=null)
    {
        $clinicIds = Clinic::select('ID')->OnlyMyPractice($practiceID)->pluck('ID')->toArray();
        $acpSetting = AcpSetting::select('setting','clinic_id')->whereIn('clinic_id',$clinicIds)->pluck('setting','clinic_id')->toArray();
        $totalReview = 0;

        $google_review = GoogleReview::select('id')->OnlyMyPractice()->get();
        foreach ($clinicIds as $id)
        {
            $dates = isset($acpSetting[$id]) ? $acpSetting[$id]['start_date'] : AcpSetting::getGoogleReviewStartDate();
            $totalReview = $totalReview + $google_review->where('clinic_id',$id)->where('create_time','>',Carbon::parse($dates))->count();
        }
        return $totalReview;
    }

    /**
     * @param $practiceID || Laravel Specific code, practiceId is required in non-laravel
     * @return mixed
     */
    public static function allReviewsCount($practiceID=null)
    {
        return static::onlyMyPractice($practiceID)->count();
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class,'clinic_id','ID');
    }

    /**
     * Get the practice associated with the Google Review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function practice() {
        return $this->belongsTo( Practice::class, 'practice_id' );
    }
}
