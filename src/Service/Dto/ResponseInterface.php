<?php

declare(strict_types=1);

namespace Imigio\Service\Dto;

interface ResponseInterface
{
    public static function fromArray(array $contents): ResponseInterface;
}
