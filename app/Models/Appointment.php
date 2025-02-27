<?php
	
	namespace App\Models;
	
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\Crypt;
	
	/**
	 * @property int $practice_id practice id
	 * @property timestamp $createdate createdate
	 * @property text $content content
	 * @property varchar $status status
	 * @property varchar $viewed viewed
	 * @property text $patname patname
	 * @property varchar $location location
	 * @property varchar $sent_to sent to
	 * @property varchar $platform platform
	 */
	class Appointment extends Model {
		
		/**
		 * @var string $table specify table name
		 * @var bool $timestamps for store created_at & updated_at time
		 */
		protected $table = 'appointments';
		public $timestamps = false;
		
		
		/**
		 * @var string[] column for allow mass assignment
		 */
		protected $fillable = [
			'platform',
			'practice_id',
			'createdate',
			'content',
			'status',
			'viewed',
			'patname',
			'location',
			'sent_to',
			'platform'
		];
		
		/**
		 * Date time columns.
		 */
		protected $casts = [ 'createdate' => 'datetime' ];
		
		
		/**
		 * Get the practice that the appointment belongs to.
		 */
		public function practice() {
			return $this->belongsTo( Practice::class, 'practice_id' );
		}
		
		/**
		 * Laravel Specific code, need laravel app key...code added to skip Laravel specific if used in plain code
		 *
		 * @param $value
		 *
		 * @return string
		 */
		public function getContentAttribute( $value ) {
			//This checks for a class that is part of Laravel but not part of the Capsule install on plain code
			if ( class_exists( "Illuminate\Encryption\Encrypter" ) ) {
				return Crypt::decryptString( $value );
			}
			
			return $value;
		}
		
		/**
		 * Laravel Specific code, need laravel app key...code added to skip Laravel specific if used in plain code
		 *
		 * @param $value
		 *
		 * @return string
		 */
		public function getPatnameAttribute( $value ) {
			//This checks for a class that is part of Laravel but not part of the Capsule install on plain code
			if ( class_exists( "Illuminate\Encryption\Encrypter" ) ) {
				return Crypt::decryptString( $value );
			}
			
			return $value;
		}
		
		/**
		 * @param string $patname
		 * @param $practiceId Laravel Specific code, practiceId is required in non-laravel
		 *
		 * @return mixed
		 */
		public static function findName( $patname = '', $practiceId = null ) {
			$pid = static::where( 'practice_id', $practiceId ?? app( 'the-practice' )->practice_id );
			
			return empty( $patname ) ? $pid : $pid->where( 'patname', 'like', "%$patname%" );
		}
		
		/**
		 * @param $practiceId Laravel Specific code, practiceId is required in non-laravel
		 *
		 * @return mixed
		 */
		public static function countWithDate( $practiceId = null ) {
			return static::selectRaw( 'count(id) as total,DATE_FORMAT(createdate,"%Y-%m-%d") as date' )
			             ->where( 'practice_id', $practiceId ?? app( 'the-practice' )->practice_id )
			             ->latest( 'date' )->groupBy( 'date' );
		}
		
		/**
		 *
		 * @param $practiceId Laravel Specific code, practiceId is required in non-laravel
		 *
		 * @return mixed
		 */
		public static function countWithMonth( $practiceId = null ) {
			return static::selectRaw( 'count(id) as total, DATE_FORMAT(createdate,"%Y-%m") as yearMonth' )
			             ->where( 'practice_id', $practiceId ?? app( 'the-practice' )->practice_id )
			             ->groupBy( 'yearMonth' );
		}
		
		/**
		 * @param $query
		 * @param $type
		 *
		 * @return void
		 */
		public function scopeCurrentMonthData( $query, $type = '' ) {
			$date = Carbon::now();
			$query->when( $type == 'monthly', function ( $query ) use ( $date ) {
				return $query->havingRaw( 'Month(date) = ' . $date->month )->havingRaw( 'YEAR(date) = ' . $date->year );
			}, function ( $query ) use ( $date ) {
				return $query->havingRaw( 'Month(concat(yearMonth,"-01")) = ' . $date->month )->havingRaw( 'YEAR(concat(yearMonth,"-01")) = ' . $date->year );
			} );
		}
		
		/**
		 * @param $query
		 * @param $type
		 *
		 * @return void
		 */
		public function scopePastMonthData( $query, $type = '' ) {
			$date = Carbon::parse( 'first day of this month' )->format( 'Y-m-d' );
			$query->when( $type == 'monthly', function ( $query ) use ( $date ) {
				return $query->havingRaw( 'date < "' . $date . '"' );
			}, function ( $query ) use ( $date ) {
				return $query->havingRaw( 'concat(yearMonth,"-01") < "' . $date . '"' );
			} );
		}
		
		/**
		 * @param $query
		 * @param $type
		 *
		 * @return void
		 */
		public function scopePracticeId( $query, $practiceId ) {
			$query->where( 'practice_id', $practiceId );
		}
		
		/**
		 * @param $query
		 * @param $type
		 *
		 * @return void
		 */
		public function scopeNotviwed( $query ) {
			$query->where( 'viewed', '!=', 'Yes' );
		}
		
	}
