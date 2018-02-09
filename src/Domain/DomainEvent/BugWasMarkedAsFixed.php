<?php
declare(strict_types=1);

namespace Bug\Domain\DomainEvent;

use Bug\Domain\Aggregate\BugStatus;
use Prooph\EventSourcing\AggregateChanged;
use Ramsey\Uuid\Uuid;

/**
 * Class BugWasMarkedAsFixed
 * @package Bug\Domain\DomainEvent
 */
class BugWasMarkedAsFixed extends AggregateChanged
{

    /**
     * @var
     */
    private $bugId;

    /**
     * @var TodoStatus
     */
    private $oldStatus;

    /**
     * @var TodoStatus
     */
    private $newStatus;


    /**
     * @param Uuid $uuid
     * @param BugStatus $oldStatus
     * @param BugStatus $newStatus
     * @return BugWasMarkedAsFixed
     */
    public static function fromStatus(Uuid $uuid, BugStatus $oldStatus, BugStatus $newStatus): BugWasMarkedAsFixed
    {
        /** @var self $event */
        $event = self::occur($uuid->toString(), [
            'old_status' => $oldStatus->toString(),
            'new_status' => $newStatus->toString()
        ]);

        $event->bugId = $uuid;
        $event->oldStatus = $oldStatus;
        $event->newStatus = $newStatus;

        return $event;
    }

    public function bugId(): Uuid
    {
        /*if (null === $this->bugId) {
            $this->todoId = TodoId::fromString($this->aggregateId());
        }*/

        return $this->bugId;
    }

    /**
     * @return BugStatus
     */
    public function oldStatus(): BugStatus
    {
        if (null === $this->oldStatus) {
            $this->oldStatus = BugStatus::byName($this->payload['old_status']);
        }

        return $this->oldStatus;
    }

    /**
     * @return BugStatus
     */
    public function newStatus(): BugStatus
    {
        if (null === $this->newStatus) {
            $this->newStatus = BugStatus::byName($this->payload['new_status']);
        }

        return $this->newStatus;
    }
}