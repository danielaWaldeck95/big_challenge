<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubmissionStatuses;
use Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
