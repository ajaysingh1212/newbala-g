<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'max_devices',
        'allow_phone',
        'allow_laptop',
        'blocked_ips',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'max_devices' => 'integer',
            'allow_phone' => 'boolean',
            'allow_laptop' => 'boolean',
            'blocked_ips' => 'array',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'user_role'
        );
    }

    public function permissions()
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->unique()
            ->toArray();
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions());
    }

    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function profilePhoto()
    {
        return $this->media()->where('collection_name', 'profile')->first();
    }

    public function canUseDeviceType(string $deviceType): bool
    {
        $deviceType = strtolower(trim($deviceType));

        if ($deviceType === 'phone' && ! $this->allow_phone) {
            return false;
        }

        if ($deviceType === 'laptop' && ! $this->allow_laptop) {
            return false;
        }

        return true;
    }

    public function detectDeviceType(?string $userAgent = null): string
    {
        $agent = strtolower((string) ($userAgent ?? ''));

        if (str_contains($agent, 'iphone') || str_contains($agent, 'android') || str_contains($agent, 'ipad') || str_contains($agent, 'mobile')) {
            return 'phone';
        }

        if (str_contains($agent, 'windows') || str_contains($agent, 'macintosh') || str_contains($agent, 'linux') || str_contains($agent, 'x11')) {
            return 'laptop';
        }

        return 'laptop';
    }

    public function isIpBlocked(?string $ip): bool
    {
        $ip = trim((string) ($ip ?? ''));

        if ($ip === '') {
            return false;
        }

        $blockedIps = array_map('trim', (array) ($this->blocked_ips ?? []));

        return in_array($ip, $blockedIps, true);
    }

    public function hasActiveSessionForDevice(?string $userAgent = null, ?string $ip = null): bool
    {
        $agent = (string) ($userAgent ?? '');
        $ip = (string) ($ip ?? '');

        $query = DB::table('sessions')
            ->where('user_id', $this->id)
            ->where('ip_address', $ip);

        if ($agent !== '') {
            $query->whereRaw('LOWER(user_agent) = ?', [strtolower($agent)]);
        }

        return $query->exists();
    }

    public function getActiveSessionCount(): int
    {
        return DB::table('sessions')
            ->where('user_id', $this->id)
            ->count();
    }

    public function canLoginOnDevice(?string $userAgent = null, ?string $ip = null): bool
    {
        $deviceType = $this->detectDeviceType($userAgent);
        $ip = trim((string) ($ip ?? ''));

        if ($this->isIpBlocked($ip)) {
            return false;
        }

        if (! $this->canUseDeviceType($deviceType)) {
            return false;
        }

        $limit = max(1, (int) $this->max_devices);
        $activeSessions = $this->getActiveSessionCount();

        if ($activeSessions >= $limit && ! $this->hasActiveSessionForDevice($userAgent, $ip)) {
            return false;
        }

        return true;
    }
}
