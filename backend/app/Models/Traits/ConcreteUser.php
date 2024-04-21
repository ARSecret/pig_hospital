<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait ConcreteUser {
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'concrete');
    }

    public function username(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->username,
        );
    }

    public function firstName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->first_name,
        );
    }

    public function lastName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->last_name,
        );
    }

    public function patronymic(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->patronymic,
        );
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->full_name,
        );
    }

    public function gender(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->gender,
        );
    }
}