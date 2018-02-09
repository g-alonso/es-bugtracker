<?php

declare(strict_types=1);

namespace Bug\Infrastructure\Repository;

use Bug\Domain\Aggregate\Bug;
use Bug\Domain\Repository\BugRepositoryInterface;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Ramsey\Uuid\Uuid;

/**
 * Class BugRepository
 * @package Bug\Infrastructure\Repository
 */
final class BugRepository extends AggregateRepository implements BugRepositoryInterface
{

    public function __construct(EventStore $eventStore)
    {
        //We inject a Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator that can handle our AggregateRoots
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass('Bug\Domain\Aggregate\Bug'),
            new AggregateTranslator(),
            null, //We don't use a snapshot store in the example
            null, //Also a custom stream name is not required
            true //But we enable the "one-stream-per-aggregate" mode
        );
    }

    public function add(Bug $bug)
    {
        $this->saveAggregateRoot($bug);
    }

    public function get(Uuid $id) : Bug
    {
        return $this->getAggregateRoot($id->toString());
    }
}
