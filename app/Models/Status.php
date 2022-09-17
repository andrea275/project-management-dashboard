<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Status extends Model
{
    use HasFactory;

    protected static function boot() {
        parent::boot();

        static::creating(function ($status) {
            do {
                $slug = Str::slug($status->name);
            } while (!empty(Status::whereSlug($slug)->first()));

            $status->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
