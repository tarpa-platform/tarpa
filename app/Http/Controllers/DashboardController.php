<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
   public function index(): Response
   {
    $active_participants = Participant::activeStatus()->count();
    $assigned_active_participants = Participant::activeStatus()->assignedToUser()->count();

    $stats = [
        [
            'model' => 'participant',
            'type' => 'all',
            'name' => 'Active Particpants',
            'stat' => $active_participants,
            'url' => route('participant.index')
        ],
        [
            'model' => 'participant',
            'type' => 'mine',
            'name' => 'Active Particpants',
            'stat' => $assigned_active_participants,
            'url' => route('participant.index', ['filter[mine]' => '1'])
        ],
        [
            'model' => 'event',
            'type' => 'all',
            'name' => 'Events this week',
            'stat' => 0,
            'url' => route('dashboard')
        ],
        [
            'model' => 'event',
            'type' => 'mine',
            'name' => 'Events this week',
            'stat' => 0,
            'url' => route('dashboard')
        ],
        [
            'model' => 'task',
            'type' => 'all',
            'name' => 'Open tasks',
            'stat' => 0,
            'url' => route('dashboard')
        ],
        [
            'model' => 'task',
            'type' => 'mine',
            'name' => 'Open tasks',
            'stat' => 0,
            'url' => route('dashboard')
        ]
    ];

    return Inertia::render('Dashboard', ['stats' => $stats]);
}
}
