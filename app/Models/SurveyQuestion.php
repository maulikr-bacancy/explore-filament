<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
  use HasFactory;

  protected $table = 'surveyquestion';


  // Eloquent does not work with Composite Primary Keys

  public function question()
  {
    $this->hasOne(Question::class, 'questionID');
  }




}
