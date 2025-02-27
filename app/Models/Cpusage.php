<?php

namespace App\Models;

use Illuminate\Support\Carbon;

class Cpusage extends AcpPracticeModel
{
    /**
     * @var string $table name
     * @var bool $timestamp for store created_at & updated_at time
     */
    protected $table = 'cpusage';
    public $timestamps = false;

    protected $casts = ['daterun' => 'datetime'];

    public static function getPracticeData($practice_id){
        return Cpusage::OnlyMyPractice($practice_id)->whereNotNull('daterun')
            ->orderBy('daterun')
            ->get();
    }

    public static function generateYearWiseArray($startDate,$cpusages,&$arrayReferences=[],$columns=[]){

        $now = Carbon::now();
        if ($startDate < $now){
            $nextYear = clone $startDate;
            $nextYear = $nextYear->addYear();
            $index = $arrayReferences[$columns[0]] ? count($arrayReferences[$columns[0]]) :0;
            foreach ($columns as $item){
                $arrayReferences[$item][$index] = 0;
            }
            $arrayReferences['years'][$index] = $startDate->format('M-Y')."/".(($nextYear > $now) ? $now->format('M-Y') : $nextYear->format('M-Y'));
            $arrayReferences['db_years'][$index] = '';
            static::generateYearWiseArray($nextYear,$cpusages,$arrayReferences,$columns);
        }else{
            // set values in array
            foreach ($cpusages as $key => $cpusage){
                $index = null;
                $indexFor3YearData = null;
                $dateToCheck = $cpusage->daterun;
                foreach ($arrayReferences['years'] as $indexKey => $dates){
                    $dates = explode('/',$dates);
                    $startDate = Carbon::createFromFormat('M-Y',$dates[0]);
                    $endDate = Carbon::createFromFormat('M-Y',$dates[1]);

                    if ($dateToCheck->between($startDate, $endDate)) {
                        $index = $indexKey;
                    }
                }
                if (!is_null($index)){
                    foreach ($columns as $columnName){
                        $arrayReferences[$columnName][$index] = $cpusage->$columnName;
                    }
                    $arrayReferences['db_years'][$index] = $cpusage->daterun->format('M-Y');
                }
            }
        }

        $withValueOnly = [];
        foreach ($arrayReferences['db_years'] as $index => $value){
            if (!empty($value)){
                $withValueOnly['db_years'][] = $value;
                foreach ($columns as $columnName){
                    $withValueOnly[$columnName][] = $arrayReferences[$columnName][$index];
                }
            }
        }
        return $withValueOnly;
    }
    public static function generateMonthWiseArrayForLastYear($startDate,$endDate,$cpusages,&$arrayReferences=[],$columns=[]){
        if ($startDate < $endDate){
            $nextMonth = clone $startDate;
            $nextMonth = $nextMonth->addMonth();
            $index = $arrayReferences[$columns[0]] ? count($arrayReferences[$columns[0]]) :0;
            foreach ($columns as $item){
                $arrayReferences[$item][$index] = 0;
            }
            $arrayReferences['years'][$index] = $startDate->format('M-Y')."/".(($nextMonth > $endDate) ? (clone $endDate)->format('M-Y') : $nextMonth->format('M-Y'));
            $arrayReferences['db_years'][$index] = '';
            static::generateMonthWiseArrayForLastYear($nextMonth,$endDate,$cpusages,$arrayReferences,$columns);
        }else{
            // set values in array
            foreach ($cpusages as $key => $cpusage){
                $index = null;
                $indexFor3YearData = null;
                $dateToCheck = $cpusage->daterun;
                foreach ($arrayReferences['years'] as $indexKey => $dates){
                    $dates = explode('/',$dates);
                    $startDate = Carbon::createFromFormat('M-Y',$dates[0]);
                    $endDate = Carbon::createFromFormat('M-Y',$dates[1]);

                    if ($dateToCheck->between($startDate, $endDate)) {
                        $index = $indexKey;
                    }
                }
                if (!is_null($index)){
                    foreach ($columns as $columnName){
                        $arrayReferences[$columnName][$index] = $cpusage->$columnName;
                    }
                    $arrayReferences['db_years'][$index] = $cpusage->daterun->format('M-Y');
                }
            }
        }
        $withValueOnly = [];
        foreach ($arrayReferences['db_years'] as $index => $value){
            if (!empty($value)){
                $withValueOnly['db_years'][] = $value;
                foreach ($columns as $columnName){
                    $withValueOnly[$columnName][] = $arrayReferences[$columnName][$index];
                }
            }
        }
        return $withValueOnly;
    }

    public function practice() {
        return $this->belongsTo( Practice::class,'practice_id');
    }
}
