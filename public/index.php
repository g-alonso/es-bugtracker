<?php



use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Bug\Domain\Command\RegisterNewBug;
use Bug\Domain\Aggregate\Bug;

require_once __DIR__."/../vendor/autoload.php";
require_once  __DIR__."/dep.php";

$commandBus = new CommandBus();
$router = new CommandRouter();

$router->route('Bug\Domain\Command\RegisterNewBug')->to(function(RegisterNewBug $o) use($bugs) {

    $bugs->add(Bug::new($o->name()));
});

$router->route('Bug\Domain\Command\MarkBugAsFixed')->to(function(\Bug\Domain\Command\MarkBugAsFixed $o) use($bugs) {

    $bug = $bugs->get($o->bugId());

    if (!$bug) {
        throw \Bug\Domain\Exception\BugNotFound::withTodoId($o->todoId());
    }

    $bug->markAsFixed();

    $bugs->add($bug);
});

$router->attachToMessageBus($commandBus);

$command = RegisterNewBug::fromName('BUG-03');
//$command = \Bug\Domain\Command\MarkBugAsFixed::forBug('d4729db8-61ef-4688-bf4b-9e8468c118cb');

$commandBus->dispatch($command);