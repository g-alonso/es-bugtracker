<?php

namespace Bug\Domain\Exception;

class BugNotFound extends \InvalidArgumentException
{
    public static function withTodoId(\Ramsey\Uuid\Uuid $uuid): BugNotFound
    {
        return new self(sprintf('Bug with id %s cannot be found.', $uuid->toString()));
    }
}
