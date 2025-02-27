<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Newslettertracking extends Model
{
  const ESP_UNKNOWN='Unknown';

  const ESP_SIB='SIB';

  const ESP_SG='SG';

  const ESP_SL='SL';

  /**
   * Database table name
   */
  protected $table = 'newslettertracking';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'trackingID';

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;

  /**
   * Mass assignable columns
   */
  protected $fillable=['socket_lab_code',
    'subID',
    'sent',
    'opened',
    'extClick',
    'intClick',
    'newsletterList',
    'newsletterTemplate',
    'newsletterID',
    'surveyClick',
    'bouncetype',
    'bouncecount',
    'bounceremove',
    'letterType',
    'practiceID',
    'delivered',
    'sendgrid_event',
    'sendgrid_timestamp',
    'ESP',
    'socket_lab_code'];


  public function newsletter()
  {
    return $this->hasOne(Newsletter::class, 'ID', 'newsletterID');
  }


}
