<?php

namespace mglaman\Units\Repository;

use mglaman\Units\Model\UnitInterface;

interface UnitRepositoryInterface
{
    /**
     * Returns the measurement unit type this repository is for.
     *
     * This will return a value such as distance, volume, weight, etc. It will
     * be used to load units from the resources folder.
     *
     * @return string
     */
    public function getType();

    /**
     * Returns a measurement unit instance by name.
     *
     * @param $unitName
     *
     * @return UnitInterface A unit instance.
     */
    public function getUnit($unitName);

    /**
     * Returns all measurement units for repository type.
     *
     * @return UnitInterface[] An array of unit instances.
     */
    public function getAll();
}
