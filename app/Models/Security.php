<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
  protected $table = 'security';
	protected $primaryKey = 'sec_id';
	
	
	public function managerHydras() {
		return $this->hasMany( 'Hydra', 'manager_id' );
	}
	
	public function primaryHydras() {
		return $this->hasMany( 'Hydra', 'primary_id' );
	}
	
	public function qaCheckerHydras() {
		return $this->hasMany( 'Hydra', 'qa_checker_id' );
	}
	
	public $timestamps = false;
}
