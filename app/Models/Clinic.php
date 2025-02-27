<?php

	namespace App\Models;

	class Clinic extends AcpPracticeModel {
		protected $table = 'clinic';
		protected $primaryKey = 'ID';
		protected $practiceKey = 'practiceID';

		/**
		 * @param $query
		 * @param $practiceId || Laravel Specific code, practiceId is required in non-laravel
		 *
		 * @return void
		 */
		public function scopeOnlyMyPractice( $query, $practiceId = null ) {
			parent::scopeOnlyMyPractice( $query, $practiceId );
		}

		/**
		 * Get the internet resources associated with the clinic.
		 */
		public function internetResources() {
			return $this->hasMany( InternetResource::class, 'location_id', 'ID' )->where('practice_id',$this->practiceID);
		}


		/**
		 * Get the practice that the clinic belongs to.
		 */
		public function practice() {
			return $this->belongsTo( Practice::class, 'practiceID', 'ID' );
		}
	}
