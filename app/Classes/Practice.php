<?php

namespace App\Classes;

use App\Models\CacheLongterm;
use App\Models\GoogleReview;
use App\Models\Practice as prac;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Practice
{
    public $practice_id;

    public $model;

    public $readMessages;

    public $newCount;

    public $finances;

    public $clinics;

    public function __construct($id = 0)
    {
        $pid = Session::get('practice_id') ?? 12;
        $pid = $id == 0 ? $pid : $id;
        $this->model = prac::find($pid);
        $this->practice_id = $pid;
        //    $this->setNewCount();
    }

    public function __get($name)
    {
        if (isset($this->model[$name])) {
            return $this->model[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): '.$name.
            ' in '.$trace[0]['file'].
            ' on line '.$trace[0]['line'],
            E_USER_NOTICE);

        return null;
    }

    public function readMessages()
    {
        if (! isset($this->readMessages)) {
            $this->readMessages = DB::table('messagesread')->where('practice_id', '=', $this->practice_id)->pluck('msgid');
        }

        return $this->readMessages;
    }

    public function setNewCount()
    {
        //remove 3 query and get same data from single query
        //    $this->newCount['appointment'] = DB::table('appointments')->where('practice_id', $this->practice_id)->where('status', 'New')->count();
        //    $this->newCount['websiteReview'] = DB::table('reviews')->where('practice_id', $this->practice_id)->where('status', 'New')->count();
        //    $this->newCount['googleReview'] = GoogleReview::countByClinic($this->practice_id);
        //    $this->newCount['message'] = DB::table('messages')->where('hide', '!=', 'True')->where('expire', '>', date('Y-m-d'))->whereNotIn('id', $this->readMessages())->count();

        $date = date('Y-m-d');
        $this->newCount = (array) DB::select("SELECT (SELECT COUNT(*) FROM appointments where practice_id = $this->practice_id and status='new') as appointment,".
            "(SELECT COUNT(*) FROM reviews where practice_id = $this->practice_id and status='new') as websiteReview,".
            "(SELECT COUNT(*) FROM messages where hide != 'True' and expire > $date and id not in (SELECT msgid FROM messagesread where practice_id = $this->practice_id)) as message")[0];
        $this->newCount['googleReview'] = GoogleReview::countByClinic($this->practice_id);

    }

    public function getNewCount()
    {
        if (! $this->newCount) {
            $this->setNewCount();
        }

        return $this->newCount;
    }

    public function finances()
    {
        if (! isset($this->finances)) {
            $this->finances = DB::table('finances')->where('practice_id', '=', $this->practice_id)->first();
        }
    }

    public function getService($service)
    {
        $this->finances();
        if ($this->finances?->$service == 1) {
            return true;
        }

        return false;
    }

    public function clinics()
    {
        if (! isset($this->clinics)) {
            $this->clinics = DB::table('clinic')->where('practiceID', '=', $this->practice_id)->get()->keyBy('ID');
        }

        return $this->clinics;
    }

    /**
     * @return mixed
     */
    public function getNewsletters($type)
    {
        $newsletters = [];
        if ($type == 'md') {
            if ($this->model->md_list != '' and $this->model->md_list != 'None') {
                $newsletters = DB::table('newsletters')->rightJoin('list', 'newsletters.ID', '=', 'list.NewsletterID')->select('Name', 'number', 'newsletters.ID', 'pdfTemplate')->where('list.List', $this->model->md_list)->where('list.display', 1)->where('pdfTemplate', '!=', 0)->oldest('list.sort')->get();
            }
        } else {
            $printableNewsletters = DB::table('newsletters')->rightJoin('list', 'newsletters.ID', '=', 'list.NewsletterID')
                ->where(['list.List' => $this->model->patient_list, 'list.display' => 1])->where('pdfTemplate', '!=', 0)->oldest('list.sort')
                ->select('Name', 'newsletters.ID');
            $newsletters = DB::table('newsletters')->where(['Type' => 'Monthly', 'year' => Carbon::now()->format('Y')])->latest('Year')->latest('month')
                ->select(DB::raw("concat(Name,'-',TRIM( LEADING '[Video]' from TRIM(broadcastsubject)) ) as Name,ID"))->unionAll($printableNewsletters)->get();
        }

        return $newsletters;
    }

    public function getClicky($practiceId, $type, $daily = null, $date = 'last-30-days', $output = 'php')
    {
        try {
            $practice = prac::find($practiceId);
            $requestUrl = 'http://api.getclicky.com/api/stats/4?site_id='.$practice->clicky.'&sitekey='.$practice->clickykey.'&type='.$type.'&date='.$date;
            if (! is_null($daily)) {
                $requestUrl .= '&daily='.$daily;
            }

            return Http::get($requestUrl.'&output='.$output);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @param  string  $key  the unique key for store cache
     * @param  function  $function  function that execute if the cache does not exist or need to update the cache
     * @param  null|string  $cache_range  define the range of data like 1-year,1-month,2-month,all-past-data
     * @param  null|Carbon  $expiration  specify the time (in carbon object) when need to update the cache set null if no need to update the cache
     * @param  null|int  $practice_id  id for the practice table
     * @return mixed cache value
     */
    public function setCache($key, $function, $cache_range = null, ?Carbon $expiration = null, $practice_id = null)
    {
        $practiceID = $practice_id ?? $this->practice_id;
        $cacheData = CacheLongterm::onlyMyPracticeCache($key, $practiceID)->first();
        $needUpdate = false;
        if (isset($cacheData->expiration)) {
            $dbExpiration = Carbon::createFromTimestamp($cacheData->expiration);
            if ($dbExpiration < Carbon::now()) {
                $needUpdate = true;
            }
        }
        if (! $cacheData || $needUpdate) {
            $cacheData = CacheLongterm::firstOrNew(['cache_key' => $key, 'practice_id' => $practiceID]);
            $cacheData->practice_id = $practice_id;
            $cacheData->cache_value = $function();
            $cacheData->cache_range = $cache_range;
            $cacheData->expiration = $expiration ? $expiration->timestamp : null;
            $cacheData->save();

        }

        return $cacheData->cache_value;
    }

    //  public function showNoService($service,$view){
    //    $this->finances();
    //    if($this->finances->$service==0){
    //      return 'components.core.notService';
    //    }else{
    //      return $view;
    //    }
    //  }
}

