<?php

namespace Bug\Domain\Aggregate;

use Bug\Domain\DomainEvent\BugWasMarkedAsFixed;
use Bug\Domain\DomainEvent\NewBugWasRegistred;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;

/**
 * Class Bug
 * @package Bug\Domain\Aggregate
 */
class Bug extends AggregateRoot
{
    /**
     * @var Uuid
     */
    private $uuid;
    /**
     * @var string
     */
    private $name;

    /**
     * @var BugStatus
     */
    private $status;

    /**
     * @param string $name
     * @return Bug
     */
    public static function new(string $name) : self
    {
        $self = new self();

        $self->recordThat(NewBugWasRegistred::occur(
            (string) Uuid::uuid4(),
            [
                'name' => $name
            ]
        ));

        return $self;
    }

    /**
     * Every AR needs a hidden method that returns the identifier of the AR as a string
     */
    protected function aggregateId(): string
    {
        return $this->uuid->toString();
    }


    /**
     *
     */
    public function markAsFixed(): void
    {
        $status = BugStatus::DONE();

        $this->recordThat(BugWasMarkedAsFixed::fromStatus($this->uuid, $this->status, $status));
    }

    /**
     * @param AggregateChanged $event
     */
    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case NewBugWasRegistred::class:
                $this->uuid = $event->uuid();
                $this->name = $event->name();
                $this->status = BugStatus::OPEN();
                break;
            case BugWasMarkedAsFixed::class:
                $this->status = $event->newStatus();
                break;
        }
    }

}