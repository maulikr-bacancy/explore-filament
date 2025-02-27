<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $old_url old url
@property varchar $new_url new url
@property int $practice_id practice id
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property Practice $practice belongsTo
 
 */
class Redirect extends Model
{
    
    /**
    * Database table name
    */
    protected $table = 'redirects';

    /**
    * Mass assignable columns
    */
    protected $fillable=['old_url',
'new_url',
'practice_id'];
	
	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];
	
    /**
    * practice
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function practice()
    {
        return $this->belongsTo(Practice::class,'practice_id');
    }




}
