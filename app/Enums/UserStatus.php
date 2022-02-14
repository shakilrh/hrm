<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserStatus extends Enum
{
    const Inactive = 0;
    const Active = 1;
    const Terminated = 2;
    const Deceased = 3;
    const Resigned = 4;
}
