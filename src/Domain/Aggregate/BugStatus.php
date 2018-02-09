<?php

namespace Bug\Domain\Aggregate;

use Bug\Domain\Enum;

/**
 * Class BugStatus
 * @package Bug\Domain\Aggregate
 */
final class BugStatus extends Enum
{
    public const OPEN = 'open';
    public const DONE = 'done';
    public const EXPIRED = 'expired';
}
