<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Enums\AppointmentStatus;

class Appointment extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => AppointmentStatus::class,
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function prettyStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => array(
                'created' => 'Создан',
                'confirmed' => 'Подтвержден',
                'cancelled' => 'Отменен',
                'didnt-come' => 'Пациент не явился',
                'successful' => 'Проведен успешно',
            )[$this->status],
        );
    }

    public function datetime(): Attribute
    {
        return Attribute::make(
            get: fn ($datetime) => new DateTime($datetime),
        );
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['created', 'confirmed']);
    }

    public function canBeConfirmed(): bool
    {
        return in_array($this->status, ['created']);
    }

    public function canBeFinished(): bool
    {
        return in_array($this->status, ['confirmed']);
    }
}
