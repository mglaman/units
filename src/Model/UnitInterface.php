<?php

/**
 *
 */

namespace mglaman\Units\Model;

/**
 * Interface UnitInterface
 * @package mglaman\Units\Model
 */
interface UnitInterface
{
    /**
     * Returns the measurement unit's label.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Sets the measurement unit's label.
     *
     * @param string $label The label.
     */
    public function setLabel($label);

    /**
     * Returns the measurement unit's plural label.
     *
     * @return string
     */
    public function getPlural();

    /**
     * Sets the measurement unit's plural label.
     *
     * @param string $plural The plural label.
     */
    public function setPlural($plural);

    /**
     * Returns the measurement unit's unit representation.
     *
     * @return string
     */
    public function getUnit();

    /**
     * Sets the measurement unit's unit representation.
     *
     * @param string $unit The unit.
     */
    public function setUnit($unit);

    /**
     * @return mixed
     */
    public function getFactor();

    /**
     * @param $float
     *
     * @return mixed
     */
    public function setFactor($float);

    /**
     * @param $value
     *
     * @return mixed
     */
    public function toBase($value);

    /**
     * @param $value
     *
     * @return mixed
     */
    public function fromBase($value);
}
