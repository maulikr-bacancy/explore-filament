<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Practice extends Model {
        use HasFactory;

		protected $table = 'practice';

		public $timestamps = false;

		protected $primaryKey = 'ID';

		/**
		 * Mass assignable columns
		 */
		protected $fillable = [
			'Name',
			'dateAdded',
			'colorScheme',
			'color_head',
			'color_framing',
			'color_section',
			'color_line',
			'color_text',
			'color_bkgrd',
			'color_input',
			'color_listtext',
			'short_name',
			'sitehide',
			'website',
			'topRightText',
			'bottomRightText',
			'newsletterReady',
			'newsletter',
			'status',
			'number_locations',
			'signature',
			'signature_email',
			'signature_phone',
			'prompt_level',
			'contact_email',
			'contact_phone',
			'contact_cell_phone',
			'found_code',
			'contact_name',
			'need_setup',
			'use_referral',
			'patient_list',
			'md_list',
			'year',
			'phase',
			'blocking_cust',
			'blocking_us',
			'in_count',
			'googleKey',
			'wsonly',
			'tempsite',
			'enhanced',
			'arb',
			'selfedit',
			'x3',
			'seotesturl',
			'searchenabled',
			'clicky',
			'clickykey',
			'nlonly',
			'newlook',
			'x3nl',
			'datequit',
			'quitreason',
			'responsible',
			'facebookid',
			'facebookurl',
			'facebookfeed',
			'facebook_locations',
			'havestore',
			'priority',
			'servicelevel',
			'wordpress',
			'wpblogid',
			'freshbooks',
			'mobilephase',
			'rms',
			'bom',
			'bomadmin',
			'in_helpscout',
			'fid',
			'wmt',
			'lrs',
			'gplus_account',
//    'intercom_id',
			'ws_local_optimized',
			'g5',
			'g5theme',
			'g5builder',
			'mssphase',
			'mssreviewmonth',
			'ncphase',
			'oldwpblogid',
			'oldlinknumber',
			'bptm',
			'placeholder',
			'prs',
			'moderation',
			'review_email',
			'alertemail',
			'alertemailapp',
			'domain_owner',
			'videos_per_month',
			'images_per_month',
			'no_third_party_msg',
			'ssl_active',
			'timezone',
			'txt180',
			'prs_notification',
			'review_notification',
			'review_notification_receiver',
			'mssStartDate',
			'mssLastDate',
			'google_reviews_ws',
			'chatbot',
			'server',
            'blog_id_new',
			'groundhogg_id',
			'bugherd_id',
			'overseasteam',
			'bugherd_api',
			'theme_type'
		];

		/**
		 * Date time columns.
		 */
		protected $casts = [
			'dateAdded'          => 'datetime',
			'arb'                => 'datetime',
			'datequit'           => 'datetime',
			'ws_local_optimized' => 'datetime',
			'data_cached_at'     => 'datetime'
		];

//		HasMany Tables======================================================
		public function appointments() {
			return $this->hasMany( Appointment::class, 'practice_id' );
		}
		public function cachelongterm() {
			return $this->hasMany( CacheLongterm::class, 'practice_id' );
		}

		public function clicktocall() {
			return $this->hasMany( Click2call::class, 'practice_id' );
		}

		public function clinics() {
			return $this->hasMany( Clinic::class, 'practiceID' );
		}

        public function domain() {
            return $this->hasMany( Domain::class, 'practice_id' );
        }

        public function fbQueues() {
            return $this->hasMany( FbQueue::class, 'practice_id' );
        }

		public function googleReviews() {
			return $this->hasMany( GoogleReview::class, 'practice_id' );
		}

		public function internetresources() {
			return $this->hasMany( InternetResource::class, 'practice_id' )->where( 'location_id', '=', 'all' );
		}
		public function reviews() {
			return $this->hasMany( Review::class, 'practice_id' );
		}

		public function subscribers() {
			return $this->hasMany( Subscriber::class, 'clinic' );
		}

        public function userAuths() {
            return $this->hasMany( UserAuth::class, 'practice_id' );
        }

        public function bounces() {
            return $this->hasMany( Bounce::class, 'practice_id' );
        }
        public function brightlocalranks() {
            return $this->hasMany( BrightlocalRank::class, 'practice_id' );
        }

        public function longtermcaches() {
            return $this->hasMany( CacheLongterm::class, 'practice_id' );
        }

        public function click2calls() {
            return $this->hasMany( Click2call::class, 'practice_id' );
        }

        public function clickies() {
            return $this->hasMany( Clicky::class, 'practice_id' );
        }

        public function configs() {
            return $this->hasMany( Config::class, 'practice_id' );
        }
        public function cpusages() {
            return $this->hasMany( Cpusage::class, 'practice_id' );
        }
        public function doc_customers() {
            return $this->hasMany( DocCustomer::class, 'practice_id' );
        }
		public function lateststatus() {
            return $this->hasMany( Lateststatus::class, 'practice_id' );
        }


//		HasOne Tables..........................................................
		public function arcontact() {
			return $this->hasOne( Arcontact::class );
		}

		public function feed_practice() {
			return $this->hasOne( Feedpractice::class );
		}

		public function finances() {
			return $this->hasOne( Finance::class, 'practice_id' );
		}

		public function landbotConfig() {
			return $this->hasOne( LandbotConfig::class );
		}

		public function survey() {
			return $this->hasOne( Survey::class, 'practiceID' );
		}

		public function surveyId() {
			return $this->hasOne( Survey::class, 'practiceID' )->value( 'ID' );

		}

		public function upgrade() {
			return $this->hasOne( Upgrade::class, 'practice_id' );
		}

        public function banned() {
            return $this->hasOne( Banned::class,'practiceID' );
        }

        public function canada() {
            return $this->hasOne( Canada::class,'practice_id' );
        }
		public function skiplist() {
            return $this->hasOne( Skiplist::class,'practice_id' );
        }
		public function hydra() {
            return $this->hasOne( Hydra::class,'practice_id' );
        }

//		Getters----------------------------------------

		/**
		 * Get the practice name with phrases abbreviated and a max length of 30
		 * @return string
		 */
		public function getCustomShortNameAttribute() {
			$shortPracticeName = [
				'Physical Therapy'    => 'PT',
				'Physiotherapy'       => 'Physio',
				'Physical Therapists' => 'PTs',
				'Rehabilitation'      => 'Rehab',
				'Performance'         => 'Perf'
			];
			$shortName         = $this->Name;
			foreach ( $shortPracticeName as $key => $value ) {
				$shortName = str_replace( $key, $value, $shortName );
			}

			return ( strlen( $shortName ) > 30 ) ? substr( $shortName, 0, 30 ) . "..." : $shortName;
		}

		/**
		 * return phase attribute with UpperCase
		 *
		 * @param $value
		 *
		 * @return string
		 */
		public function getPhaseAttribute( $value ) {
			return ucwords( $value );
		}

		/**
		 * append https protocol to get website URL
		 * @return string
		 */
		public function getWebsiteURLAttribute() {
			return "https://" . $this->website;
		}

		/**
		 * return bptm attribute with UpperCase
		 * @return string
		 */
		public function getBptmAttribute( $value ) {
			return ucwords( $value );
		}

//		Scope (returned values) >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		public function scopeBPTMIsNotEqual( $query, $bptm ) {
			return $query->where( 'bptm', '!=', $bptm );
		}
		public function scopeClicky( $query, $clicky ) {
			return $query->where( 'clicky', $clicky );
		}

		public function scopeFacebookURL( $query, $status = true ) {
			if ( $status == true ) {
				return $query->whereNotNull( 'facebookurl' );
			}

			return $query->whereNull( 'facebookurl' );
		}
		public function scopeInCount( $query, $count ) {
			return $query->where( 'in_count', $count );
		}

		public function scopeLive( $query ) {
			return $query->where( 'phase', 'fully active' )->where( 'in_count', 1 );
		}

		public function scopeMobilePhase( $query, $mobilePhase ) {
			return $query->where( 'mobilephase', $mobilePhase );
		}

		public function scopeNewsletterOnly( $query, $status ) {
			if ( $status == true ) {
				return $query->where( 'nlonly', 1 );
			}
			return $query->where( 'nlonly', '!=', 1 );
		}

		public function scopeNoNewsletter( $query ) {
			return $query->where( 'nlonly', '!=', 1 )->orWhereNull( 'nlonly' );
		}

		public function scopePhase( $query, $phase ) {
			return $query->where( 'phase', $phase );
		}

		public function scopeStatus( $query, $status ) {
			return $query->where( 'status', $status );
		}
        public function routeNotificationFor($driver)
        {
            // Example for database notifications
            if ($driver === 'database') {
                return $this->morphMany('Illuminate\Notifications\DatabaseNotification', 'notifiable');
            }

            // Example for mail notifications:
            if ($driver === 'mail') {
                return $this->signature_email;
            }
            // Return null if no specific route is defined
            return null;
        }

	}
