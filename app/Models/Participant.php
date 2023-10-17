<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Participant extends Model implements Searchable
{
    use HasFactory, HasUuids, SoftDeletes;

    public static $model_display_name = 'Study Participant';

    public static $model_key_display_name = 'name';

    protected $fillable = [
        'name',
        'canonical_id',
        'member_id',
        'timepoint_id',
        'status_id',
        'email_address'
    ];

    protected $with = [
        'status',
        'timepoint',
        'member'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function timepoint(): BelongsTo
    {
        return $this->belongsTo(Timepoint::class);
    }

    public function getSearchResult(): SearchResult
    {
       $url = route('participant.show', $this->id);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->name,
           $url
        );
    }

    public function scopeAssignedToUser(Builder $query): void
    {
        $query->whereHas('member', function (Builder $query) {
            $query->where('id', Auth::user()->linkable->id);
        });
    }

    public function scopeActiveStatus(Builder $query): void
    {
        $query->whereHas('status', function(Builder $query) {
            $query->where('is_active', true);
        });
    }

    /**
     * Resolve this model to its view and data properties.
     */
    public static function resolve()
    {
        return [
            'view' => 'Participant/View',
            'data' => 'participant'
        ];
    }
}
