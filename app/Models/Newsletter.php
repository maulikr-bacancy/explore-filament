<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Newsletter extends Model
{

  /**
   * Database table name
   */
  protected $table = 'newsletters';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'ID';

  /**
   * Mass assignable columns
   */
  protected $fillable=['guid',
    'number',
    'Name',
    'Type',
    'Framework',
    'PDF',
    'Quote',
    'Preview',
    'Summary',
    'PictureURL',
    'NumberSections',
    'Content',
    'htmlTemplate',
    'pdfTemplate',
    'txtTemplate',
    'listTemplate',
    'broadcastfor',
    'contentfile',
    'broadcastsubject',
    'month',
    'year',
    'customertype',
    'showarchive',
    'guid'];

  public function scopeOnlyTypes($query,$type)
  {
    $query->whereIn('Type', $type);
  }



}
