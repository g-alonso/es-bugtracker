<?php


use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Bug\Domain\Command\RegisterNewBug;
use Bug\Domain\Aggregate\Bug;

require_once __DIR__."/../vendor/autoload.php";

$commandBus = new CommandBus();
$router = new CommandRouter();

$router->route('Bug\Domain\Command\RegisterNewBug')->to(function(RegisterNewBug $o){

    $pdo = new PDO('mysql:dbname=todo;host=127.0.0.1', 'root', '123');
    $eventStore = new MySqlEventStore(new FQCNMessageFactory(), $pdo, new \Prooph\EventStore\Pdo\PersistenceStrategy\MySqlSingleStreamStrategy());

    $eventStore = new ActionEventEmitterEventStore(
        $eventStore,
        new ProophActionEventEmitter()
    );
    $bugs = new \Bug\Infrastructure\Repository\BugRepository($eventStore);
    $bugs->add(Bug::new($o->name()));
});

$router->attachToMessageBus($commandBus);

$echoText = RegisterNewBug::fromName('BUG-02');

$commandBus->dispatch($echoText);