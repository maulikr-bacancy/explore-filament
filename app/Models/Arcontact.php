<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Casts\AsArrayObject;
	
	
	class Arcontact extends Model {
		protected $table = "arcontact";
		
		public $timestamps = false;
		
		protected $primaryKey = 'practice_id';
		
		protected $fillable=[
			'practice_id',
			'contact_name',
			'contact_email',
			'form_type',
			'form_url',
			'last_check',
			'last_result',
			'review_check',
			'review_by',
			'fields',
			'rules',
			'emails',
			'uses_count',
			'failure_count',
		];
	
	protected $casts = [
		'fields' => AsArrayObject::class,
		'rules' => AsArrayObject::class,
		'emails' => AsArrayObject::class,
	];
		
		/**
		 * return related practice if any
		 * @return mixed
		 */
		public function practice() {
			return $this->belongsTo( Practice::class);
		}
		
	}
