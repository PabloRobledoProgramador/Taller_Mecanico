<?php

namespace App\Models;

use App\Enums\Role;
use App\Notifications\RoleChangedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * 'role' NO es asignable en masa a propósito: así nadie puede
     * auto-asignarse admin desde un formulario. Se cambia con changeRole().
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class, 'mechanic_id');
    }

    public function hasRole(Role|string ...$roles): bool
    {
        foreach ($roles as $role) {
            $role = $role instanceof Role ? $role : Role::from($role);
            if ($this->role === $role) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::Admin);
    }

    public function isMecanico(): bool
    {
        return $this->hasRole(Role::Mecanico);
    }

    /**
     * Cambia el rol y avisa al usuario (campana + correo).
     */
    public function changeRole(Role $role): void
    {
        if ($this->role === $role) {
            return;
        }

        $this->forceFill(['role' => $role])->save();
        $this->notify(new RoleChangedNotification($role));
    }
}
