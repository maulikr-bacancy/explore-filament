<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Newslettersforcustomer extends Model
{

    /**
    * Database table name
    */
    protected $table = 'newslettersforcustomers';

    protected $primaryKey = 'ID';

    /**
    * Mass assignable columns
    */
    protected $fillable=['broadcastdate',
//'practice_id',
'number',
'Name',
'Type',
'Content',
'htmlTemplate',
'txtTemplate',
'subject',
'month',
'year',
'customertype',
'sendstatus',
'broadcastdate'];

    /**
    * Date time columns.
    */
    protected $casts=['broadcastdate' =>'datetime'];




}
