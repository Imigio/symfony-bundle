<?php

declare(strict_types=1);

namespace Imigio\Service;

class ImigioRelationMapping
{
    public function __construct(
        private array $mapping = [],
    )
    {}

    public function getClassNamespace(string $relationName): ?string
    {
        return $this->mapping[$relationName] ?? null;
    }
}
