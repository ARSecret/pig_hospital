<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nurse extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }
}
