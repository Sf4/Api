<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 31.01.19
 * Time: 10:45
 */

namespace Sf4\Api\Dto\Order;

abstract class AbstractOrder implements OrderInterface
{

    public const PROPERTY_DIRECTION = 'direction';
    public const PROPERTY_FIELD = 'field';

    /** @var string $direction */
    protected $direction;

    /** @var string $field */
    protected $field;

    public function populate(array $data): void
    {
        if (isset($data[static::PROPERTY_DIRECTION], $data[static::PROPERTY_FIELD])) {
            $this->setDirection($data[static::PROPERTY_DIRECTION]);
            $this->setField($data[static::PROPERTY_FIELD]);
        }
    }

    public function toArray(): array
    {
        return [
            static::PROPERTY_DIRECTION => $this->getDirection(),
            static::PROPERTY_FIELD => $this->getField()
        ];
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        if (!$this->direction) {
            $this->direction = static::DIRECTION_ASCENDING;
        }
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        if (false === $this->directionExists($direction)) {
            $direction = static::DIRECTION_ASCENDING;
        }
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        if (!$this->field) {
            $this->field = static::DEFAULT_FIELD;
        }
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field): void
    {
        if (false === $this->fieldExists($field)) {
            $field = static::DEFAULT_FIELD;
        }
        $this->field = $field;
    }

    /**
     * @param string $direction
     * @return bool
     */
    protected function directionExists(string $direction): bool
    {
        return in_array($direction, [
            static::DIRECTION_ASCENDING,
            static::DIRECTION_DESCENDING
        ], true);
    }

    /**
     * @param string $field
     * @return bool
     */
    protected function fieldExists(string $field): bool
    {
        return in_array($field, $this->getAvailableFields(), true);
    }
}
