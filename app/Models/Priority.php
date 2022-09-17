<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Priority extends Model
{
    use HasFactory;

    protected static function boot() {
        parent::boot();

        static::creating(function ($priority) {
            do {
                $slug = Str::slug($priority->name);
            } while (!empty(Priority::whereSlug($slug)->first()));

            $priority->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
