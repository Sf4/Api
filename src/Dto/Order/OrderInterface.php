<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 31.01.19
 * Time: 9:43
 */

namespace Sf4\Api\Dto\Order;

interface OrderInterface
{

    const DIRECTION_ASCENDING = 'ASC';
    const DIRECTION_DESCENDING = 'DESC';
    const DEFAULT_FIELD = 'id';

    public function setDirection(string $direction);

    public function getDirection(): string;

    public function setField(string $field);

    public function getField(): string;

    public function getAvailableFields(): array;

    public function populate(array $data);

    public function toArray(): array;
}
