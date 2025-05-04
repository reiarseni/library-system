<?php

namespace App\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class AdminPanelAuthentication implements Guard
{
    public function user(): ?Authenticatable
    {
        $user = Auth::user();

        // Verificar si el usuario tiene rol de administrador
        if ($user && $user->role === 'admin') {
            return $user;
        }

        return null;
    }

    public function id(): ?string
    {
        return $this->user()?->getAuthIdentifier();
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function guest(): bool
    {
        return ! $this->check();
    }

    public function validate(array $credentials = []): bool
    {
        $user = Auth::validate($credentials);

        if (! $user) {
            return false;
        }

        if ($user->role !== 'admin') {
            return false;
        }

        return true;
    }

    public function setUser(Authenticatable $user): void
    {
        Auth::setUser($user);
    }
}
