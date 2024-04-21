<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $dateTime
 * @property int $patient_id
 * @property int $doctor_id
 * @property \App\Models\Enums\AppointmentStatus $status
 * @property-read mixed $datetime
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Patient|null $patient
 * @property-read mixed $pretty_status
 * @method static \Database\Factories\AppointmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 */
	class Appointment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $datetime
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $text
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Patient $patient
 * @method static \Database\Factories\CaseRecordFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CaseRecord whereUpdatedAt($value)
 */
	class CaseRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @mixin Eloquent
 * @property int $id
 * @property int $speciality_id
 * @property bool $active
 * @property string|null $photo_url
 * @property string $workday_start
 * @property string $workday_end
 * @property string $lunch_start
 * @property string $lunch_end
 * @property string $appointment_duration
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CaseRecord> $caseRecords
 * @property-read int|null $case_records_count
 * @property-read \App\Models\Nurse|null $nurse
 * @property-read \App\Models\Speciality $speciality
 * @method static \Database\Factories\DoctorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereAppointmentDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereLunchEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereLunchStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor wherePhotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereSpecialityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereWorkdayEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereWorkdayStart($value)
 */
	class Doctor extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $date
 * @property string $title
 * @property string $text
 * @property string|null $image_url
 * @method static \Database\Factories\NewsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $doctor_id
 * @property-read \App\Models\Doctor|null $doctor
 * @method static \Database\Factories\NurseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Nurse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nurse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nurse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nurse whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurse whereId($value)
 */
	class Nurse extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $birthdate
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CaseRecord> $case_records
 * @property-read int|null $case_records_count
 * @property-read mixed $first_name
 * @property-read mixed $full_name
 * @property-read mixed $last_name
 * @property-read mixed $patronymic
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PatientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 */
	class Patient extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|Speciality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Speciality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Speciality query()
 * @method static \Illuminate\Database\Eloquent\Builder|Speciality whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Speciality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Speciality whereName($value)
 */
	class Speciality extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $gender
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property int $concrete_id
 * @property string $concrete_type
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $concrete
 * @property-read mixed $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConcreteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConcreteType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

