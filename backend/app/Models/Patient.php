<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function case_records(): HasMany
    {
        return $this->hasMany(CaseRecord::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->full_name,
        );
    }

    public function getAge(): int {
        $birthdate = new DateTime($this->birthdate);
        $now = new DateTime('today');
        return ($now->diff($birthdate))->y;
    }
}
