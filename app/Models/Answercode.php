<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answercode extends Model
{
  use HasFactory;

  protected $table = 'answercode';

//  protected $primaryKey = ['answerCode', 'questionID']; @todo why two column use for the primary key ?

}
