<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelStatus\Status;

class TaskStatus extends Status
{
    use HasFactory, HasUuids;

    protected $table = 'task_statuses';
}
