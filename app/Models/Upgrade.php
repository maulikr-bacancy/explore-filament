<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $practice_id
 * @property string $nameServer
 * @property string $transfer
 * @property string $emails
 * @property string $base
 * @property string $firstVisit
 * @property string $nlsignup
 * @property string $enhancednl
 * @property string $chart
 * @property string $wizard
 * @property string $hosting
 * @property integer $numbergodaddy
 * @property string $cptrained
 * @property string $wpe_migration
 * @property boolean $hs_corr
 * @property boolean $in_count
 * @property string $telehealth
 * @property string $clover_connect
 */
class Upgrade extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'upgrade';

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
    protected $fillable = ['nameServer', 'transfer', 'emails', 'base', 'firstVisit', 'nlsignup', 'enhancednl', 'chart', 'wizard', 'hosting', 'numbergodaddy', 'cptrained', 'wpe_migration', 'hs_corr', 'in_count', 'telehealth', 'clover_connect'];

    public function practice() {
        return $this->belongsTo( Practice::class, 'practice_id' );
    }
}
