<?php

use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlSingleStreamStrategy;

$pdo = new PDO('mysql:dbname=todo;host=127.0.0.1', 'root', '12345');
$eventStore = new MySqlEventStore(new FQCNMessageFactory(), $pdo, new MySqlSingleStreamStrategy());

$eventStore = new ActionEventEmitterEventStore(
    $eventStore,
    new ProophActionEventEmitter()
);
$bugs = new \Bug\Infrastructure\Repository\BugRepository($eventStore);