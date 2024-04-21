<?php

namespace App\Models\Enums;

enum AppointmentStatus: string {
    case Created = 'created';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Successful = 'successful';
    case DidntCome = 'didnt-come';
}