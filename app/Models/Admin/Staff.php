<?php

namespace App\Models\Admin;

use App\Traits\MediaConversions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string|null $profileImageUrl
 */
class Staff extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRoles,
        HasPermissions,
        SoftDeletes,
        InteractsWithMedia,
        MediaConversions {
            MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
        }

    const ADMIN_ID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Apply the basic search scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $term
     * @return void
     */
    public function scopeSearch($query, $term)
    {
        if (! $term) {
            return;
        }

        $query->where(function ($query) use ($term) {
            $parts = array_map('trim', explode(' ', $term));
            foreach ($parts as $part) {
                $query->where('email', 'LIKE', "%$part%")
                    ->orWhere('first_name', 'LIKE', "%$part%")
                    ->orWhere('last_name', 'LIKE', "%$part%");
            }
        });
    }

    public function profileImageUrl(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getFirstMediaUrl('avatar', conversionName: 'thumb') ?: '/assets/images/user.jpg'
        );
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->first_name.' '.$this->last_name
        );
    }

    public function guardName(): string
    {
        return 'admin';
    }

    public function isAdmin(): bool
    {
        return $this->is_admin ?? false;
    }

    /**
     * Authorize an action via permissions.
     *
     * @param  string | array<mixed>  $permission
     */
    public function authorize($permission): bool
    {
        if (! is_array($permission)) {
            $permission = [$permission];
        }

        return $this->hasAllPermissions($permission);
    }
}
