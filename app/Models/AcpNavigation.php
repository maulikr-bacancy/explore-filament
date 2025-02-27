<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class AcpNavigation extends Model
{
    use HasFactory;

    public function parent() {
        return $this->hasOne('App\Models\acpNavigation', 'id', 'parent_link_id');
    }

    public function children() {
        return $this->hasMany('App\Models\acpNavigation', 'parent_link_id', 'id');
    }

    public function scopeMainMenu(Builder $query): Builder
    {
        return $query->whereNull("parent_link_id");
    }

    public function scopeCurrentMenu($query)
    {
        $requestPath = request()->path();
        if ($requestPath=='livewire/update'){
            $requestPath = parse_url(request()->headers->get('referer'), PHP_URL_PATH);
        }
        return $query->where('link',$requestPath)->orWhere('link',"/".$requestPath)->first();
    }

    public function isExternalLinkType(): bool
    {
        return $this->link_type === 'external';
    }
    public function childrenRecursive()
    {
        return $this->hasMany(acpNavigation::class, 'parent_link_id', 'id')->with('childrenRecursive');
    }
    public function getLinkAttribute($value)
    {
        $practice = app('the-practice')->model;
        if ($practice) {
            $value = str_replace('{practice_short_name}', $practice->short_name, $value);
            $value = str_replace('{practice_sitehide}', $practice->sitehide, $value);
        }
        return $value;
    }
}
