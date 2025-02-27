<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySet extends Model
{
    use HasFactory;
    protected $table = 'surveyset';
    protected $fillable = ['time','numanswers','surveyID'];
    public $timestamps = false;

}
