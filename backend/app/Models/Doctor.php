<?php

namespace App\Models;

use App\Models\Traits\ConcreteUser;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;

/**
 * @mixin Eloquent
 */
class Doctor extends Model
{
    use HasFactory;
    use ConcreteUser;

    public $timestamps = false;

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }  

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function caseRecords(): HasMany
    {
        return $this->hasMany(CaseRecord::class);
    }

    public function nurse(): HasOne
    {
        return $this->hasOne(Nurse::class);
    }

    public function getPatients(): Collection
    {
        $fromAppointments = $this->appointments->pluck('patient');
        $fromCaseRecords = $this->caseRecords->pluck('patient');
        return $fromAppointments->merge($fromCaseRecords)->unique();
    }

    public function getPossibleAppointmentDatetimes(DateTime $date): array
    {
        $workdayStart = new DateTime("{$date->format('Y-m-d')} {$this->workday_start}");
        $dayOfWeek = $workdayStart->format('w');
        if (in_array($dayOfWeek, [0, 6])) {
            return array();
        }

        $workdayEnd = new DateTime("{$date->format('Y-m-d')} {$this->workday_end}");
        $lunchStart = new DateTime("{$date->format('Y-m-d')} {$this->lunch_start}");
        $lunchEnd = new DateTime("{$date->format('Y-m-d')} {$this->lunch_end}");
        $appointmentDuration = new DateInterval($this->appointment_duration);

        $possibleAppointments = array();
        $datetime = clone $workdayStart;
        while ($datetime < $lunchStart) {
            $possibleAppointments[] = clone $datetime;
            $datetime->add($appointmentDuration);
        }
        $datetime = clone $lunchEnd;
        while ($datetime < $workdayEnd) {
            $possibleAppointments[] = clone $datetime;
            $datetime->add($appointmentDuration);
        }

        return $possibleAppointments;
    }

    public function getAvailableAppointmentDatetimes(DateTime $date): array
    {
        $unavailableDatetimes = $this->appointments()
            ->whereIn('status', ['confirmed', 'successful'])
            ->whereDate('datetime', $date)
            ->pluck('datetime')
            ->map(fn ($datetimeString) => new DateTime($datetimeString))
            ->toArray();
        $availableDatetimes = $this->getPossibleAppointmentDatetimes($date);
        $availableDatetimes = array_udiff(
            $availableDatetimes, 
            $unavailableDatetimes, 
            fn ($possible, $unavailable) => $possible <=> $unavailable
        );
        $availableDatetimes = array_filter(
            $availableDatetimes, function ($datetime) {
                return $datetime > new DateTime('tomorrow');
            }
        );

        return $availableDatetimes;
    }

    public function addAppointment(Patient $patient, DateTime $datetime): Appointment | null
    {
        $availableAppointments = $this->getAvailableAppointmentDatetimes($datetime);
        if (!in_array($datetime, $availableAppointments)) {
            return null;
        }

        $appointment = new Appointment;
        $appointment->patient()->associate($patient);
        $appointment->doctor()->associate($this);
        $appointment->date_time = $datetime;
        $appointment->save();

        return $appointment;
    }
}
