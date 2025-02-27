<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Clicky extends Model
{

    /**
     * Database table name
     */
    protected $table = 'clicky';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['theme',
//    'practice_id',
        'phonenumber',
        'created_time',
        'user_agent',
        'user_ip',
        'theme'];

    /**
     * Date time columns.
     */
    protected $casts = ['created_time' => 'datetime'];

    public static function countWithDate($practiceId)
    {
        return Static::selectRaw('count(id) as total,DATE_FORMAT(created_time,"%Y-%m-%d") as date')
            ->where('practice_id', $practiceId)
            ->latest('date')->groupBy('date');
    }

    public function scopeCurrentMonthData($query)
    {
        $date = Carbon::now();
        $query->havingRaw('Month(date) = ' . $date->month)->havingRaw('YEAR(date) = ' . $date->year);
    }

    public function scopePastMonthData($query)
    {
        $date = Carbon::parse('first day of this month')->format('Y-m-d');
        $query->havingRaw('date < "' . $date . '"');
    }

    public function scopeOnlyYearAgo($query,$year)
    {
        $date = Carbon::now()->subYear($year)->startOfYear()->format('Y-m-d');
        return $query->havingRaw('date > "' . $date . '"');
    }



    public function scopePractice($query,$practiceId)
    {
        return $query->where('practice_id',$practiceId);
    }

    public function scopeStat($query,$stat)
    {
        return $query->where('stat',$stat);
    }

    public function scopeMonth($query,$month)
    {
        return $query->where('month',$month);
    }

    public function scopeYear($query,$year)
    {
        return $query->where('year',$year);
    }

    public function practice() {
        return $this->belongsTo( Practice::class,'practice_id');
    }
}
