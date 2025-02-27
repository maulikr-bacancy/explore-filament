<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $casts = [
        'data' =>'array',
        'read_at' =>'datetime'
    ];
    private $notificationTypes = [
        'App\Notifications\PracticeNotification' => 'Practice Notification',
        'App\Notifications\User' => 'User Notification',
        // Add more mappings as needed
    ];
    public function getLocalCreatedAtAttribute()
    {
        $timezone = auth()->check() ? auth()->user()->timezone : config('app.timezone');
        return $this->attributes['created_at'] ? Carbon::parse($this->attributes['created_at'])->timezone($timezone) : null;
    }
    public function getLocalReadAtAttribute()
    {
        $timezone = auth()->check() ? auth()->user()->timezone : config('app.timezone');
        return $this->attributes['read_at'] ? Carbon::parse($this->attributes['read_at'])->timezone($timezone) : null;
    }
    public function notifiable()
    {
        return $this->morphTo();
    }

    public function getFormattedTypeAttribute()
    {
        return $this->notificationTypes[$this->attributes['type']];
    }
    public function getFormattedDataAttribute()
    {
        return "<pre>".$this->attributes['data']."</pre>";
    }

    /**
     * Scope a query to only include unread notifications.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('read_at', null);
    }
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }
    public function scopeRelated($query)
    {
        return $query->where(function ($query) {
            // Filter notifications for the current practice
            $query->where('notifiable_type', 'App\Models\Practice')
                ->where('notifiable_id', session('practice_id'));
        })->orWhere(function ($query) {
            // Filter notifications for the current authenticated user
            $query->where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', auth()->id());
        });
    }
    public static function markAsRead($notificaitonId = null)
    {
        if (!empty($notificaitonId)) {
            return Notification::Related()->Unread()->where('id',$notificaitonId)->update(['read_at' => now()]);
        }else{
            return Notification::Related()->Unread()->update(['read_at' => now()]);
        }
    }

}
