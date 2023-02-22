<?php

declare(strict_types=1);

namespace App\Enums;

enum SubmissionStatuses: string
{
    case Pending = 'pending';
    case InProgress = 'in progress';
    case Done = 'done';
}
