<?php

namespace App\Models;

use App\Models\Traits\ConcreteUser;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Patient extends Model
{
    use HasFactory;
    use ConcreteUser;

    public $timestamps = false;

    protected $fillable = [
        'birthdate',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function case_records(): HasMany
    {
        return $this->hasMany(CaseRecord::class);
    }

    public function getAge(): int {
        $birthdate = new DateTime($this->birthdate);
        $now = new DateTime('today');
        return ($now->diff($birthdate))->y;
    }
}
