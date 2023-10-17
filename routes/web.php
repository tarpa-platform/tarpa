<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimepointController;
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function() {

    /**
     * Dashboard
     */

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Notifications
     */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    /**
     * Archive
     */
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archive.index');
    Route::get('/archives/{archive}', [ArchiveController::class, 'show'])->name('archive.show');

    /**
     * Participants
     */

    Route::get('/participants', [ParticipantController::class, 'index'])->name('participant.index');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participant.store');
    Route::get('/participants/{participant}', [ParticipantController::class, 'show'])->name('participant.show');
    Route::patch('/participants/{participant}', [ParticipantController::class, 'update'])->name('participant.update');

    /**
     * Members
     */

    Route::get('/members', [MemberController::class, 'index'])->name('member.index');
    Route::post('/members', [MemberController::class, 'store'])->name('member.store');
    Route::patch('/members/{member}/restore', [MemberController::class, 'restore'])->withTrashed()->name('member.restore');
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('member.show');
    Route::patch('/members/{member}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/members/{member}', [MemberController::class, 'delete'])->name('member.delete');

    /**
     * Tasks
     */

    Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('task.show');

    /**
     * Statuses
     */

    Route::get('/statuses', [StatusController::class, 'index'])->name('status.index');
    Route::post('/statuses', [StatusController::class, 'store'])->name('status.store');
    Route::get('/statuses/{status}', [StatusController::class, 'show'])->name('status.show');

    /**
     * Roles and Permissions
     */

    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('role.store');
    Route::get('/roles/create-new', [RoleController::class, 'create'])->name('role.create');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('role.update');

    /**
     * User Profile
     */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /**
     * Timepoints
     */

    Route::middleware('longitudinal')->group(function() {
        Route::get('/timepoints', [TimepointController::class, 'index'])->name('timepoint.index');
        Route::post('/timepoints', [TimepointController::class, 'store'])->name('timepoint.store');
        Route::get('/timepoints/{timepoint}', [TimepointController::class, 'show'])->name('timepoint.show');
    });

    /**
     * Settings
     */

    Route::get('/settings', [SettingController::class, 'edit'])->name('setting.edit');
    Route::patch('/settings', [SettingController::class, 'update'])->name('setting.update');

    /**
     * List Roles API
     */
    Route::get('/api/roles', function () {
        return app(App\Models\Role::class)->all()->setVisible(['id', 'name', 'description']);
    })->name('api.role.list');

    /**
     * List User Notification Count API
     */
    Route::get('/api/notifications', [NotificationController::class, 'unread'])->name('api.notifications.count');

    /**
     * Mark User Notifications as read
     */
    Route::get('/api/notifications/read', [NotificationController::class, 'mark_read'])->name('api.notifications.read');

    /**
     * List Statuses API
     */
    Route::get('/api/statuses', function () {
        return app(App\Models\Status::class)->all()->setVisible(['id', 'description', 'is_active', 'is_default']);
    })->name('api.status.list');

    Route::get('/api/search', function(Request $request){
        if(!$request->query('q')){
            return [];
        };

        $searchResults = (new Search())
            ->registerModel(App\Models\Member::class, 'name')
            ->registerModel(App\Models\Participant::class, ['name', 'canonical_id'])
            ->limitAspectResults(25)
            ->search($request->query('q'));
        return $searchResults->groupByType();
    })->name('api.search');

});

require __DIR__.'/auth.php';
