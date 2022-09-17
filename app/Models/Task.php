<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($task) {
            do {
                $uuid = Str::uuid();
            } while (!empty(Task::whereUuid($uuid)->first()));

            $task->uuid = $uuid;
        });
    }

    static $rules = [
        'title' => ['required', 'string', 'max:255'],
        'status' => ['required', 'integer', 'exists:statuses,id'],
        'priority' => ['nullable', 'integer', 'exists:priorities,id'],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }
}
