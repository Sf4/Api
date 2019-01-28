<?php

namespace Sf4\Api\Dto;

interface DtoInterface
{
    /**
     * @param array|object|null $data
     * @throws \ReflectionException
     */
    public function populate(array $data): void;

    /**
     * @return array
     */
    public function toArray(): array;
}
