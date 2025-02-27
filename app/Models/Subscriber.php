<?php

namespace App\Models;

use Illuminate\Support\Carbon;

class Subscriber extends AcpPracticeModel
{
    /**
     * Database table name
     */
    protected $table = 'subscribers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'subscriber_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'kickbox_date',
        'first_name',
        'last_name',
        'name',
        'email',
        'last_message',
        'date_added',
        'full_date_added',
        'date_stopped',
        'full_date_stopped',
        'not_sub_reason',
        'is_sub',
        'ip_address',
        'web_form_url',
        'is_html',
        'clinic', // both the column clinic & practice_id has same data both store practice_id
    'practice_id', // both the column clinic & practice_id has same data both store practice_id
        'type',
        'code',
        'firstLetter',
        'date_last',
        'email_validated',
        'bouncetype',
        'bouncecount',
        'kickbox',
        'survey_sent',
        'date_discharged',
        'addbyid',
        'payload',
        'kickbox_reason',
        'kickbox_date',
        'acp'
    ];

    /**
     * Date time columns.
     */
    protected $casts = [
        'date_added' => 'datetime',
        'date_stopped' => 'datetime',
        'date_discharged' => 'datetime',
        'full_date_added' => 'datetime',
        'full_date_stopped' => 'datetime'
    ];

    public function getAddedDateAttribute()
    {
        return $this->date_added->format(config('constants.date_format.full_date'));
    }

    public function setDateDischargedAttribute($value)
    {
        $this->attributes['date_discharged'] = $value;
    }

    public function setDateStoppedAttribute($value)
    {
        $this->attributes['date_stopped'] = $value;
    }

    public function getFullnameAttribute($value)
    {
        return $this->name ? $this->name : (($this->first_name or $this->last_name) ? $this->first_name or $this->last_name : '');
    }

    /**
     * @param $query
     * @param $is_sub
     * @param $type
     * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
     * @return mixed
     */
    public static function findSubs($query = '', $is_sub = -1, $type = 'Patient', $practiceId=null)
    {
        return static::OnlyMyPractice($practiceId)
            ->Type($type)
            ->when($is_sub>=0,function ($query) use ($is_sub){
                $query->where('is_sub', $is_sub);
            })
            ->where('email', 'like', "%$query%");
    }

    public function firstNewsletter()
    {
        return $this->hasOne(Newsletter::class, 'ID', 'firstLetter');
    }

    public function newslettersSent()
    {
        return $this->hasMany(Newslettertracking::class, 'subID', 'subscriber_id');
    }

    public function newsletter()
    {
        return $this->hasManyThrough(Newsletter::class, Newslettertracking::class, 'subID', 'ID', 'subscriber_id', 'newsletterID');
    }

    public function notSubReasonDescription()
    {
        if ($this->is_sub == 1) return '';
        $nsr = $this->not_sub_reason;
        if ($nsr == 'autoUnsub.php in NL') return 'User unsubscribed';
        if ($nsr == 'control_panel_unsub') return 'Unsubscribed in Control Panel';
        if ($nsr == 'SIB: blocked') return 'Email Blocked';
        if ($nsr == 'SIB: hard_bounce') return 'Stopped by Hard Mailbox Failure';
        if ($nsr == 'SL: hard_bounce') return 'Stopped by Hard Mailbox Failure';
        if ($nsr == 'SIB: invalid_email') return 'Stopped By Invalid Email';
        if ($nsr == 'SIB: soft_bounce >3') return 'Stopped by Repeated Mailbox Failures';
        if ($nsr == 'SL: soft_bounce >3') return 'Stopped by Repeated Mailbox Failures';
        if ($this->bouncetype != null) return 'Stopped by Mailbox Failure';
        return 'Unknown';
    }

    /**
     * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
     * @return mixed
     */
    public static function countWithDate($practiceId = null)
    {
        $practiceId = $practiceId ?? app('the-practice')->practice_id;
        return static::selectRaw('FROM_UNIXTIME(date_added,"%Y-%m-%d") as date,count(*) as total')
            ->OnlyMyPractice($practiceId)
            ->Type('Patient')
            ->groupBy('date');
    }

    public static function countWithYearly($practiceId = null, $type = 'Patient', $is_sub = null, $dateColumn = 'date_added')
    {
        $query = static::selectRaw('FROM_UNIXTIME(' . $dateColumn . ',"%Y-%m") as date,count(*) as total')
            ->whereNotNull($dateColumn)
            ->OnlyMyPractice($practiceId)
            ->Type($type);
        if (!is_null($is_sub)) {
            $query->where('is_sub', $is_sub);
        }
        return $query->oldest('date')->groupBy('date');
    }


    public static function scopeOnlySubscriber($query,$is_sub=1)
    {
        $query->where('is_sub', $is_sub);
    }

    public function scopeCurrentMonthData($query, $type = '')
    {
        $date = Carbon::now();
        $query->when($type == 'monthly', function ($query) use ($date) {
            return $query->havingRaw('Month(date) = ' . $date->month)->havingRaw('YEAR(date) = ' . $date->year);
        }, function ($query) use ($date) {
            return $query->havingRaw('Month(concat(date,"-01")) = ' . $date->month)->havingRaw('YEAR(concat(date,"-01")) = ' . $date->year);
        });
    }

    public function scopePastMonthData($query, $type = '')
    {
        $date = Carbon::parse('first day of this month')->format('Y-m-d');
        $query->when($type == 'monthly', function ($query) use ($date) {
            return $query->havingRaw('date < "' . $date . '"');
        }, function ($query) use ($date) {
            $query->havingRaw('concat(date,"-01") < "' . $date . '"');
        });
    }

    public function scopeBetweenDate($query, $startDate , $endDate)
    {
        return $query->where('date_added','>',$startDate)->where('date_added','<',$endDate);
    }

    public function scopeActive($query)
    {
        return $query->where('is_sub',1);
    }

    public function scopeInActive($query)
    {
        return $query->where('is_sub',0);
    }

    /**
     * @param $limit
     * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
     * @return mixed
     */
    public static function recentlyAddedSubscriber($limit=5, $practiceId=null)
    {
        return Subscriber::select('email', 'date_added','type')->OnlyMyPractice($practiceId)->latest('date_added')->limit($limit)->get();
    }

    public static function inactivatedSubscriber($practiceId)
    {
        return Static::OnlyMyPractice($practiceId)->OnlySubscriber(0)->Type('Patient');
    }

    public static function NLSent($practiceId)
    {
        return Newslettertracking::from('newslettertracking as n')->selectRaw('count(n.trackingID) as count, letterType')
            ->join('subscribers as s', 's.subscriber_id', '=', 'n.subID')
            ->where('s.clinic', $practiceId)
            ->where('s.type', 'patient')->whereIn('n.letterType', ['normal', 'broadcast', 'month', 'discharge'])->groupBy('letterType')->get();
    }

    public static function NLOpen($practiceId)
    {
        return Newslettertracking::from('newslettertracking as n')->selectRaw('count(n.trackingID) as count, letterType')
            ->join('subscribers as s', 's.subscriber_id', '=', 'n.subID')
            ->where('s.clinic', $practiceId)
            ->where('s.type', 'patient')->whereIn('n.letterType', ['normal', 'broadcast', 'month', 'discharge'])->whereNotNull('n.opened')->groupBy('letterType')->get();
    }

    public static function activatedSubscriber($practiceId)
    {
        return Static::OnlyMyPractice($practiceId)->OnlySubscriber(1)->Type('Patient');
    }
    /**
     * Get the practice associated with the Subscriber.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function practice() {
        return $this->belongsTo( Practice::class, 'practice_id' );
    }
}
