<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LeaveStatus extends Enum
{
    const Pending = 0;
    const Approved = 1;
    const Rejected = 2;
}
