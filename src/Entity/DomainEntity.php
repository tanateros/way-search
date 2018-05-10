<?php

namespace WaySearch\Entity;

use WaySearch\Entity\Exception\KeyNotExistsException;

/**
 * Class DomainEntity
 *
 * @package WaySearch\Entity
 */
abstract class DomainEntity
{
    /**
     * @param string $key
     *
     * @return mixed
     * @throws KeyNotExistsException
     */
    public function __get(string $key)
    {
        if (!property_exists($this, $key)) {
            throw new KeyNotExistsException(static::class . " has not {$key}.");
        }

        return $this->$key;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode(get_class_vars(static::class));
    }
}
