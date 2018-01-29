<?php
declare(strict_types=1);

namespace Bug\Domain\DomainEvent;

use Prooph\EventSourcing\AggregateChanged;

/**
 * Class NewBugWasRegistred
 * @package Bug\Domain\DomainEvent
 */
class NewBugWasRegistred extends AggregateChanged
{

    public function name() : string
    {
        return $this->payload['name'];
    }
}