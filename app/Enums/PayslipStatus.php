<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PayslipStatus extends Enum
{
    const Unpaid = 0;
    const Paid = 1;
}
