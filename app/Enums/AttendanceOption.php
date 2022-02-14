<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AttendanceOption extends Enum
{
    const Absence = 0;
    const Present  = 1;
    const Leave = 2;
}
