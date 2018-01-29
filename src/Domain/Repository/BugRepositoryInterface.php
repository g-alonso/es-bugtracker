<?php

declare(strict_types=1);

namespace Bug\Domain\Repository;

use Bug\Domain\Aggregate\Bug;
use Ramsey\Uuid\Uuid;

/**
 * Interface BugRepositoryInterface
 * @package Bug\Domain\Repository
 */
interface BugRepositoryInterface
{
    public function add(Bug $building);
    public function get(Uuid $id) : Bug;
}
