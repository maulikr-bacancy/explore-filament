<?php

namespace App\Models;

class Bounce extends AcpPracticeModel
{
    /**
     * @var string $table name
     * @var bool $timestamp for store created_at & updated_at time
     */
    protected $table = 'bounce';
    public function practice()
    {
        return $this->belongsTo('App\Models\Practice', 'practice_id');
    }
}
