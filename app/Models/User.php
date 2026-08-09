<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * Domain email yang diizinkan mengakses panel admin/CMS.
     *
     * @var array<int, string>
     */
    protected static array $allowedPanelDomains = [
        'bintanindustrial.co.id',
        'biie.co.id',
    ];

    /**
     * Tentukan apakah user boleh mengakses panel admin/CMS.
     * Hanya email dengan domain yang diizinkan yang diperbolehkan.
     */
    public function canAccessPanel(): bool
    {
        $domain = strtolower(substr((string) strrchr($this->email, '@'), 1));

        return in_array($domain, static::$allowedPanelDomains, true);
    }
}
