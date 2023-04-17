<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $mime_type
 * @property int|null $size
 * @property int $submission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Submission $submission
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Prescription extends Model
{
    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
    ];

    /**
     * @return BelongsTo<Submission>
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
}
