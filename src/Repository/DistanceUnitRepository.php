<?php

namespace mglaman\Units\Repository;

class DistanceUnitRepository extends UnitRepository
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'distance';
    }
}
