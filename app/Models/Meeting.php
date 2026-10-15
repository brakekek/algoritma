<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Meeting extends Model
{
    protected $fillable = ['number', 'title', 'slug', 'description', 'is_open', 'sort_order'];

    protected function casts(): array
    {
        return ['is_open' => 'boolean'];
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class)->orderBy('original_name');
    }

    protected static function booted(): void
    {
        static::creating(function (Meeting $meeting) {
            if (blank($meeting->slug)) {
                $meeting->slug = Str::slug($meeting->number . '-' . $meeting->title);
            }
        });
    }
}
