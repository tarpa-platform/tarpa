<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\ModelStatus\HasStatuses;
use App\Settings\TaskSettings;

class Task extends Model
{
    use HasFactory, HasUuids, HasStatuses, SoftDeletes;

    public static $model_display_name = 'Task';

    public static $model_key_display_name = 'title';

    protected $with = [
        'assigned_member',
        'completed_member',
        'participant',
        'statuses'
    ];

    protected $appends = ['current_status', 'completed'];

    public function assigned_member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'assigned_to', 'id');
    }

    public function completed_member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'completed_by', 'id');
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }

    protected function currentStatus(): Attribute
	{
		return Attribute::make(
			get: fn() => $this->status
		);
	}

    protected function completed(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->status == app(TaskSettings::class)->completed
        );
    }

    protected static function booted()
    {
        static::creating(function ($task) {
            $task->setStatus('created', 'Created by ' . Auth::user()->name);
        });
    }


    /**
     * Resolve this model to its view and data properties.
     */
    public static function resolve()
    {
        return [
            'view' => 'Task/Edit',
            'data' => 'task'
        ];
    }
}
