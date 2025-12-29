<?php

namespace App\Enums;

enum EnumsRoles:string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case FINANCE = 'finance';
    case HR = 'hr';
    case EMPLOYEE = 'employee';
}
