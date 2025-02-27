<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property bigint unsigned $practice_id practice id
@property varchar $condition_source condition source
@property varchar $condition_value condition value
@property varchar $email_recipient email recipient
@property smallint $time1 time1
@property smallint $time2 time2
@property smallint $time3 time3
@property enum $time1_format time1 format
@property enum $time2_format time2 format
@property enum $time3_format time3 format
@property varchar $escalation_email escalation email
@property smallint $escalation_time escalation time
@property smallint $escalation_day_offset escalation day offset
@property enum $escalation_time_format escalation time format
@property tinyint $send_on_weekends send on weekends
@property timestamp $created_at created at
@property timestamp $updated_at updated at
 
 */
class ArNotifyRule extends Model
{

    /**
    * Database table name
    */
    protected $table = 'ar_notify_rules';

    /**
    * Mass assignable columns
    */
    protected $fillable=['practice_id',
'condition_source',
'condition_value',
'email_recipient',
'time1',
'time2',
'time3',
'time1_format',
'time2_format',
'time3_format',
'escalation_email',
'escalation_time',
'escalation_day_offset',
'escalation_time_format',
'send_on_weekends'];
	
	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];



}
