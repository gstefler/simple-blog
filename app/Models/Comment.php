<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Gate;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'content',
        'user_id'
    ];

    protected $appends = [
        'can_delete'
    ];

    protected function casts(): array
    {
        return [
            'can_delete' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    protected function canDelete(): Attribute
    {
        return Attribute::make(
            get: fn () => Gate::allows('delete', $this)
        );
    }
}
