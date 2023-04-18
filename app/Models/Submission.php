<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubmissionStatuses;
use Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Submission
 *
 * @property int                             $id
 * @property string                          $title
 * @property string                          $symptoms
 * @property SubmissionStatuses              $status
 * @property int|null                        $doctor_id
 * @property int                             $patient_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $doctor
 * @property-read \App\Models\User $patient
 * @property-read \App\Models\Prescription|null $prescription
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereSymptoms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Submission whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Submission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'symptoms',
        'patient_id',
        'doctor_id',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => SubmissionStatuses::class
    ];

    /**
     * @return BelongsTo<User, Submission>
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * @return BelongsTo<User, Submission>
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * @return HasOne<Prescription>
     */
    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class);
    }

    public static function newFactory(): Factory
    {
        return SubmissionFactory::new();
    }
}
