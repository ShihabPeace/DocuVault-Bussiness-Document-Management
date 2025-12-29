<?php

namespace App\Enums;

enum EnumsStatus :string
{
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';
}
