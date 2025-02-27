<?php
namespace App\Models;

use App\Jobs\CachePractices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;

class UserAuth extends Model
{

    /**
    * Database table name
    */
    protected $table = 'acp_user_auth';

    /**
    * Mass assignable columns
    */
    protected $fillable=['role','status'];
  public static function boot() {
    parent::boot();
    static::created(function($item) {
      Bus::batch(new CachePractices(["ID" => $item->practice_id]))->dispatch();
    });
  }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function practice(){
        return $this->belongsTo(Practice::class,'practice_id','ID');
    }



}
