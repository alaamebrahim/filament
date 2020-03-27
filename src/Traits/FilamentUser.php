<?php

namespace Filament\Traits;

use Filament\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;
use Spatie\Permission\Traits\HasRoles;
use Filament\Traits\FillsColumns;

trait FilamentUser 
{
    use HasRoles, FillsColumns;
        
    /**
     * Initialize the trait.
     * 
     * @return void
     */
    public function initializeFilamentUser()
    {
        $this->mergeCasts([
            'avatar' => 'array',
            'is_super_admin' => 'boolean',
            'last_login_at' => 'datetime',
        ]);
    }

    /**
     * Get the user's avatar.
     * 
     * @param int $size
     * @return string
     */
    public function avatar($size = 48)
    {
        return Gravatar::src($this->email, (int) $size);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Hash the users password.
     *
     * @param  string  $pass
     * @return void
     */
    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }
}