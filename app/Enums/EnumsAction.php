<?php

namespace App\Enums;

enum EnumsAction: string
{
    case CREATE = 'created';
    case PUBLISH = 'published';
    case UPDATE = 'updated';
    case DELETE = 'deleted';
    case VIEW = 'viewed';
}
