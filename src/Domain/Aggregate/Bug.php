<?php

namespace Bug\Domain\Aggregate;

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


    public function markAsFixed(): void
    {
        $status = BugStatus::FIXED();

        /*if (! $this->status->is(TodoStatus::OPEN())) {
            throw Exception\TodoNotOpen::triedStatus($status, $this);
        }*/

        $this->recordThat(BugWasMarkedAsFixed::fromStatus($this->uuid, 'ad', $status, $this->assigneeId));
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case NewBugWasRegistred::class:
                //Simply assign the event payload to the appropriate properties
                $this->uuid = $event->uuid();
                $this->name = $event->name();
                break;
        }
    }

}