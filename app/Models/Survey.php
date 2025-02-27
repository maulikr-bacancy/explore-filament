<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Survey extends AcpPracticeModel
{
    use HasFactory;

    protected $table = 'survey';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $hidden = ['pivot'];
    protected $practiceKey = 'practiceId';

    public function scopeOnlyMyPractice($query, $practiceId = null)
    {
        parent::scopeOnlyMyPractice($query, $practiceId);
    }

    public function surveySet()
    {
        return $this->hasMany(SurveySet::class, 'surveyID');
    }

    public function surveyAnswerFromSet()
    {
        return $this->hasManyThrough(SurveyAnswer::class, SurveySet::class, 'surveyID', 'surveysetID', 'ID', 'ID');
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'surveyID');
    }

//  public function surveyQuestionsOrig()
//  {
//    return DB::table('question')->join('surveyquestion', 'question.ID', '=', 'surveyquestion.questionID')->select('questionID', 'question.question', 'questionType', 'questionWidth', 'questionFormat')->where('surveyID', $this->ID)->orderBy('sortOrder')->get();
//  }

    public function questions()
    {
        return $this->belongsToMany(Question::class,'surveyquestion','surveyID','questionID')->withPivot('sortOrder')->oldest('sortOrder');
    }
    public function surveyQuestions()
    {
        $questions = json_decode(json_encode($this->questions), true);
        $key = "allSurveyAnswers_survey-" . $this->ID;
        $allAnswers = Cache::remember($key, now()->endOfDay() , function () {
            return DB::table('surveyanswers')->where('surveyID', $this->ID)->select('answer', 'questionID', 'surveysetID')->get();
        });
        foreach ($questions as $questionKey => $question) {
            $question['surveyAnswers'] = $allAnswers->where('questionID', $question['ID'])->pluck('answer', 'surveysetID')->toArray();
            $question['surveyAnswers'] = array_filter($question['surveyAnswers'], 'strlen');
            $question['total'] = count($question['surveyAnswers']);
            $question['answerCode'] = ''; // Need to make processQuestion method work with Single and Multiples
            $question = Survey::processQuestion($question);
            $questions[$questionKey]=$question;
        }
        return $questions;
    }

    public function surveyQuestionsForChart()
    {
        $questionsData = $this->questions()->with('answersChoices')->get();
        $key = "allSurveyAnswers_survey-" . $this->ID;
        $allAnswers = Cache::remember($key, now()->endOfDay() , function () {
            return DB::table('surveyanswers')->where('surveyID', $this->ID)->select('answer', 'questionID', 'surveysetID')->get();
        });
        $questions = [];
        foreach ($questionsData as $question){
            $data = [
                'ID' => $question->ID,
                'question' => $question->question,
                'questionFormat' => $question->questionFormat,
                'answers' => Question::answers($question)
            ];
            $surveyAnswers = $allAnswers->where('questionID', $question->ID)->groupBy('answer')->map->count()->toArray();

            $i = 0;
            $total = 0;
            foreach ($surveyAnswers as $index => $val)
            {
                $total = $total+$val;
            }
            $data['total'] = $total;
            foreach ($surveyAnswers as $index => $val)
            {
                $data['percents'][$index] = $val*100/$total;
            }

            $answers = [];
            $percents = [];
            foreach ($data['answers'] as $index => $val){
                $answers[$i] = $index;
                $percents[$i] = $data['percents'][$val] ?? 0;
                $i++;
            }
            $data['answers'] = $answers;
            $data['percents'] = $percents;

            $questions[] = $data;
        }

        return $questions;
    }

    public function sanitizeSurveyQuestions()
    {
        $questions = $this->questions;
        $surveyQuestions = [];
        foreach ($questions as $question)
        {
            if(!in_array($question->questionFormat,['ta','tb','p','label','sublabel']))
            {
                $key = AcpSetting::encodeSetting($question->question);
                $surveyQuestions[$key] = true;
            }
        }
        return $surveyQuestions;
    }

    public static function processQuestion($question)
    {
        $question['questionID'] = $question['ID'];
        $question['textAnswer'] = false;
        $question['filter'] = 99999;
        switch ($question['questionFormat']) {
            case "label";
            case "sublabel";
                $question['label'] = true;
                $question['textAnswer'] = true;
                $question['answerChoices'] = array("Label" => 0);
                break;
            case "ta";
            case "tb";
            case "p";
                $question['textAnswer'] = true;
                $question['answer'] = 'No Answer';
                if (strlen($question['answerCode'])) $question['answer'] = $question['answerCode'];
                // From P case
                $question['answerChoices'] = array("Text Answers" => 0);

                break;
            case "r";
            case "dd";
                $question['answerChoices'] = DB::table('answercode')->where('questionID', $question['ID'])->orderBy('sortOrder', 'asc')->orderBy('answercode', 'asc')->pluck('answerCode', 'answerCodeValue')->all();
                $question['answer'] = DB::table('answercode')->where('questionID', $question['ID'])->where('answerCode', $question['answerCode'])->value('answerCodeValue');
                break;
            case "m";
                $question['answerChoices'] = array("Very Good" => '1', 'Good' => '2', 'Average' => '3', 'Below Average' => '4');
                break;
            case "e";
                $question['answerChoices'] = array("Excellent" => '5', "Very Good" => '4', 'Good' => '3', 'Fair' => '2', 'Poor' => '1', 'Not Applicable' => '0');
                break;
            case "er";
                $question['answerChoices'] = array("Poor" => '0', "Fair" => '1', 'Average' => '2', 'Good' => '3', 'Excellent' => '4', 'Not Applicable' => '5');
                break;
            case "pm";
                $question['answerChoices'] = array("100%" => '5', "75%" => '4', '50%' => '3', '25%' => '2', '0%' => '1', 'Not Applicable' => '0');
                break;
            case "a";
                $question['answerChoices'] = array("Strongly Agree" => '1', 'Agree' => '2', 'Disagree' => '3', 'Strongly Disagree' => '4', 'No Opinion' => '5');
                break;
            case "aa";
                $question['answerChoices'] = array("Strongly Disagree" => '1', 'Disagree' => '2', 'Neither Agree nor Disagree' => '3', 'Agree' => '4', 'Strongly Agree' => '5', 'No Opinion' => '6');
                break;
            case "sat";
                $question['answerChoices'] = array("Very Satisfied" => '1', 'Somewhat Satisfied' => '2', 'Neither Satisfied nor Dissatisfied' => '3', 'Somewhat Dissatisfied' => '4', 'Very Dissatisfied' => '5');
                break;
            case "sat2";
                $question['answerChoices'] = array("Very Satisfied" => '1', 'Somewhat Satisfied' => '2', 'Neutral' => '3', 'Dissatisfied' => '4');
                break;
            default;
        }
        if (!$question['textAnswer']) {
            $question=Survey::answerCalculations($question);
        }
        return $question;
    }

    public static function answerCalculations($question){
//    if(is_object($q)){
//      $question=json_decode(json_encode($q), true);
//    }else{
//      $question=$q;
//    }
        if(!isset($question['surveyAnswers'])){
            $question['total']=0;
            return $question;
        }
        $question['surveyAnswersCount'] = array_count_values($question['surveyAnswers']);
        $total = 0;
        $numans = 0;
        foreach ($question['answerChoices'] as $key => $value) {
            $numans++;
            $total += $question['surveyAnswersCount'][$value] ?? 0;;
        }
        $question['total']=$total;
        unset($question['answers']);
        unset($question['percents']);
        foreach ($question['answerChoices'] as $key => $value) {
            $theValue = $question['surveyAnswersCount'][$value] ?? 0;
            $percent = $total == 0 ? 0 : (round($theValue / $total, 2)) * 100;
            $question['answers'][] = $key;
            $question['percents'][] = $percent;
        }
        return $question;
//    if(is_array($q))return $question;
//    return (object) $question;
    }



    // Eloquent does not work with Composite Primary Keys
//  So trying to the hasManyThrough below will not work
//
//  public function surveyQuestion(){
//    return $this->hasManyThrough(Question::class,SurveyQuestion::class,'surveyID','ID','ID');
//  }

    /**
     * Get the practice associated with the Survey.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function practice() {
        return $this->belongsTo(Practice::class, 'practiceID' );
    }


}
