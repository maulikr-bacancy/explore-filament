<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  use HasFactory;

  protected $primaryKey = 'ID';
  protected $table = 'question';

//  public function answers()
//  {
//    return $this->hasMany(Answercode::class, 'questionID');
//  }

  public function answersChoices()
  {
    return $this->hasMany(Answercode::class, 'questionID')->oldest('sortOrder');
  }

  static function answers($question){
    switch ($question->questionFormat) {
      case "label";
      case "sublabel";
      case "ta";
      case "tb";
      case "p";
        return array("Text Answers" => 0);
      case "r";
      case "dd";
        return $question->answersChoices->pluck('answerCode','answerCodeValue')->toArray();
      case "m";
      return array("Very Good" => '1', 'Good' => '2', 'Average' => '3', 'Below Average' => '4');
      case "e";
      return array("Excellent" => '5', "Very Good" => '4', 'Good' => '3', 'Fair' => '2', 'Poor' => '1', 'Not Applicable' => '0');
      case "er";
      return array("Poor" => '0', "Fair" => '1', 'Average' => '2', 'Good' => '3', 'Excellent' => '4', 'Not Applicable' => '5');
      case "pm";
      return array("100%" => '5', "75%" => '4', '50%' => '3', '25%' => '2', '0%' => '1', 'Not Applicable' => '0');
      case "a";
      return array("Strongly Agree" => '1', 'Agree' => '2', 'Disagree' => '3', 'Strongly Disagree' => '4', 'No Opinion' => '5');
      case "aa";
      return array("Strongly Disagree" => '1', 'Disagree' => '2', 'Neither Agree nor Disagree' => '3', 'Agree' => '4', 'Strongly Agree' => '5', 'No Opinion' => '6');
      case "sat";
      return array("Very Satisfied" => '1', 'Somewhat Satisfied' => '2', 'Neither Satisfied nor Dissatisfied' => '3', 'Somewhat Dissatisfied' => '4', 'Very Dissatisfied' => '5');
      case "sat2";
      return array("Very Satisfied" => '1', 'Somewhat Satisfied' => '2', 'Neutral' => '3', 'Dissatisfied' => '4');
      default;
    }
    return [];
  }

}
