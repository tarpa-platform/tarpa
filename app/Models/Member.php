<?php

namespace App\Models;

use App\Traits\HasArchives;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Member extends Model implements Searchable
{
    use HasFactory, HasUuids, SoftDeletes, HasArchives, Notifiable;

    protected $table = 'teammembers';

    protected $with = ['token'];

    protected $hidden = ['user'];

    public static $model_display_name = 'Research Team Member';

    public static $model_key_display_name = 'name';

    protected $appends = [
        'user_roles'
    ];

    protected $fillable = [
        'name',
        'email_address',
        'is_assignable'
    ];

    public function archive(): MorphOne
    {
        return $this->morphOne(Archive::class, 'archivable');
    }

    public function model_display_name()
    {
        return static::$model_display_name;
    }

    public function model_key_display_name()
    {
        return static::$model_key_display_name;
    }

    /**
     * Get the teammember's user.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'linkable');
    }

    public function token()
    {
        return $this->morphOne(SignupToken::class, 'registrant');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function getUserRolesAttribute()
    {
        if ($this->user) {
            return $this->user->roles->pluck('name');
        }

        if ($this->token){
            return [$this->token->signup_role . ' (pending)'];
        }

        return [];
    }

    /**
     * Resolve this model to its view and data properties.
     */
    public static function resolve()
    {
        return [
            'view' => 'Member/Edit',
            'data' => 'member'
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('serviceaccount', function (Builder $builder) {
            $builder->where('email_address', '<>', 'hello@tarpa.xyz');
        });
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeAssignable(Builder $query): void
    {
        $query->where('is_assignable', 1);
    }

    public function getSearchResult(): SearchResult
     {
        $url = route('member.show', $this->id);

         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
     }

    /**
     * Route notifications for the mail channel.
     *
     * @return  array<string, string>|string
     */
    public function routeNotificationForMail(Notification $notification): array|string
    {
        // Return email address and name...
        return [$this->email_address => $this->name];
    }
}
