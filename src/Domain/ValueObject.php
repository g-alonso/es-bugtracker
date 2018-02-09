<?php

namespace Bug\Domain;

interface ValueObject
{
    public function sameValueAs(ValueObject $object): bool;
}
