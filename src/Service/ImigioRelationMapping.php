<?php

declare(strict_types=1);

namespace Imigio\Service;

class ImigioRelationMapping
{
    private array $mapping = [];

    public function __construct(
        array $mapping = [],
    )
    {
        foreach ($mapping as $relationName => $namespace) {
            $relationName = str_replace('_', '-', $relationName);
            $this->mapping[$relationName] = $namespace;
        }
    }

    public function getClassNamespace(string $relationName): ?string
    {
        return $this->mapping[$relationName] ?? null;
    }
}
