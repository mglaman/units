<?php

namespace mglaman\Units\Repository;

use mglaman\Units\Model\Unit;

/**
 * Class UnitRepository
 * @package mglaman\Units\Repository
 */
abstract class UnitRepository implements UnitRepositoryInterface
{

    /**
     * @var string
     */
    protected $unitsPath;
    /**
     * @var array
     */
    protected $units = [];

    /**
     * Creates a UnitRepository instance.
     *
     * @param string $unitsPath Path to measurement unit definitions.
     *                          Defaults to 'resources/[type]/'.
     *
     * @throws \Exception
     */
    public function __construct($unitsPath = null)
    {
        $this->unitsPath = $unitsPath ?: __DIR__ . '/../../resources/' . $this->getType() . '/';

        if (!is_dir($this->unitsPath)) {
            throw new \Exception(sprintf('Invalid units resource path: %s', $this->unitsPath));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUnit($unitName)
    {
        $definition = $this->loadUnit($unitName);

        if (!$definition) {
            throw new \Exception(sprintf('Unknown unit: %s', $unitName));
        }

        return $this->createUnitFromDefinition($this->loadUnit($unitName));


    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $units = [];
        if ($handle = opendir($this->unitsPath)) {
            while (false !== ($entry = readdir($handle))) {
                if (substr($entry, 0, 1) != '.') {
                    $unitName = strtok($entry, '.');
                    $units[$unitName] = $this->getUnit($unitName);
                }
            }
            closedir($handle);
        }

        return $units;
    }

    /**
     * @param $unitName
     *
     * @return mixed
     */
    protected function loadUnit($unitName)
    {
        if (!isset($this->units[$unitName])) {
            $filename = $this->unitsPath . $unitName . '.json';
            $definition = @file_get_contents($filename);
            if ($definition) {
                $this->units[$unitName] = json_decode($definition, true);
            } else {
                $this->units[$unitName] = [];
            }
        }

        return $this->units[$unitName];
    }

    /**
     * @param $definition
     *
     * @return \mglaman\Units\Model\Unit
     */
    protected function createUnitFromDefinition($definition)
    {
        $unit = new Unit();
        $unit
          ->setLabel($definition['label'])
          ->setPlural($definition['plural'])
          ->setUnit($definition['unit'])
          ->setFactor($definition['factor']);
        return $unit;
    }
}
