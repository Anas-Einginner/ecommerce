<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profie;
// ✅ Spatie
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    public function profile()
    {
        return $this->hasOne(profie::class, 'user_id');
    }

    protected string $guard_name = 'web';


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'date_of_birth',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+
                'last_login_at' => 'datetime',

    ];

    /* =====================================================
     | 🔹 Scopes (اختياري – احترافي)
     ===================================================== */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /* =====================================================
     | 🔹 Helpers (مفيدة للـ UI)
     ===================================================== */

    public function getRolesListAttribute(): string
    {
        return $this->roles->pluck('name')->join(', ');
    }

    public function getPermissionsListAttribute(): string
    {
        return $this->getAllPermissions()
            ->pluck('name')
            ->join(', ');
    }

    /* =====================================================
     | 🔹 Checks (أنظف من hasRole مباشرة بالـ Views)
     ===================================================== */

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
}
