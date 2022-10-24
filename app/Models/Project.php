<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            do {
                $slug = Str::slug($project->title);
            } while (!empty(Project::whereSlug($slug)->first()));

            $project->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    static $rules = [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:1500']
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('is_admin');
    }
}
