<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $practice_id
 * @property integer $setup_fee_amount
 * @property integer $monthly_fee_amount
 * @property integer $setup_amount_paid
 * @property boolean $paying_monthly
 * @property boolean $paid_setup
 * @property string $date_monthly_started
 * @property integer $date_setup_paid
 * @property string $notes
 * @property string $date_domain_expires
 * @property boolean $have_cc
 * @property integer $signup_date
 * @property string $source
 * @property boolean $ws
 * @property boolean $nl
 * @property boolean $mobile
 * @property boolean $seo
 * @property boolean $local
 * @property boolean $repm
 * @property boolean $mss
 * @property boolean $mss_lite
 * @property boolean $vm
 * @property boolean $google_ads
 * @property integer $auditted
 * @property boolean $special
 * @property boolean $specialpayment
 * @property string $pi_state
 * @property string $pi_notes
 * @property string $pi_amount
 * @property boolean $offer_new_look
 * @property boolean $offer_lrs
 * @property string $pi_time
 * @property boolean $pi_add_mobile
 * @property string $pi_review_date
 * @property boolean $pi_arb
 * @property integer $pi_old_rate
 * @property boolean $customer_notified
 * @property boolean $pdr
 * @property boolean $godaddy_included
 * @property integer $corporate_owner_id
 * @property boolean $corporate_pays
 * @property boolean $check_payer
 * @property string $billing_name
 */
class Finance extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'practice_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['setup_fee_amount', 'monthly_fee_amount', 'setup_amount_paid', 'paying_monthly', 'paid_setup', 'date_monthly_started', 'date_setup_paid', 'notes', 'date_domain_expires', 'have_cc', 'signup_date', 'source', 'ws', 'nl', 'mobile', 'seo', 'local', 'repm', 'mss', 'mss_lite', 'vm', 'google_ads', 'auditted', 'special', 'specialpayment', 'pi_state', 'pi_notes', 'pi_amount', 'offer_new_look', 'offer_lrs', 'pi_time', 'pi_add_mobile', 'pi_review_date', 'pi_arb', 'pi_old_rate', 'customer_notified', 'pdr', 'godaddy_included', 'corporate_owner_id', 'corporate_pays', 'check_payer', 'billing_name'];

    public $timestamps = true;
    public function practice() {
        return $this->belongsTo(Practice::class, 'practice_id' );
    }
}
