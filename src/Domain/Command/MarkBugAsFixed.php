<?php


namespace Bug\Domain\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Ramsey\Uuid\Uuid;

/**
 * Class MarkBugAsFixed
 * @package Bug\Domain\Command
 */
final class MarkBugAsFixed extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function forBug(string $bugId): MarkBugAsFixed
    {
        Assertion::uuid($bugId);

        return new self([
            'bug_id' => $bugId,
        ]);
    }

    public function bugId(): Uuid
    {
        return Uuid::fromString($this->payload['bug_id']);
    }

}