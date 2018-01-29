<?php

namespace Bug\Domain\Aggregate;

use MabeEnum\Enum;

/**
 * Class BugStatus
 * @package Bug\Domain\Aggregate
 */
final class BugStatus extends Enum
{
    public const OPEN = 'open';
    public const FIXED = 'fixed';
    public const CLOSED = 'closed';

}