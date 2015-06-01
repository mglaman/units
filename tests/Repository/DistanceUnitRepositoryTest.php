<?php

namespace mglaman\Units\Tests\Repository;

use mglaman\Units\Repository\DistanceUnitRepository;
use org\bovigo\vfs\vfsStream;

/**
 * @coversDefaultClass \mglaman\Units\Repository\DistanceUnitRepository
 */
class DistanceUnitRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Units.
     *
     * @var array
     */
    protected $units = [
        'meter' => [
            'label' => 'meter',
            'plural' => 'meters',
            'unit' => 'm',
            'factor' => 1,
        ],
        'foot' => [
          'label' => 'foot',
          'plural' => 'feet',
          'unit' => 'ft',
          'factor' => 3.048E-1,
        ],
        'inch' => [
          'label' => 'inch',
          'plural' => 'inches',
          'unit' => 'in',
          'factor' => 2.54E-2,
        ],
    ];

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        // Mock the existence of JSON definitions on the filesystem.
        $root = vfsStream::setup('resources');
        $directory = vfsStream::newDirectory('distance')->at($root);
        foreach ($this->units as $name => $data) {
            $filename = $name . '.json';
            vfsStream::newFile($filename)->at($directory)->setContent(json_encode($data));
        }

        $distanceUnitRepository = new DistanceUnitRepository('vfs://resources/distance/');
        $unitsPath = $this->getObjectAttribute($distanceUnitRepository, 'unitsPath');
        $this->assertEquals('vfs://resources/distance/', $unitsPath);

        return $distanceUnitRepository;
    }

    /**
     * @covers ::getType
     * @depends testConstructor
     *
     * @param DistanceUnitRepository $distanceUnitRepository
     */
    public function testGetType($distanceUnitRepository)
    {
        $this->assertEquals('distance', $distanceUnitRepository->getType());
    }

    /**
     * @covers ::getUnit
     * @depends testConstructor
     *
     * @param DistanceUnitRepository $distanceUnitRepository
     */
    public function testGetUnit($distanceUnitRepository)
    {
        $foot = $distanceUnitRepository->getUnit('foot');

        $this->assertInstanceOf('mglaman\Units\Model\Unit', $foot);
        $this->assertEquals('foot', $foot->getLabel());
        $this->assertEquals('feet', $foot->getPlural());
        $this->assertEquals('ft', $foot->getUnit());
        $this->assertEquals(3.048E-1, $foot->getFactor());
    }

    /**
     * @covers ::getAll
     * @depends testConstructor
     *
     * @param DistanceUnitRepository $distanceUnitRepository
     */
    public function testGetAll($distanceUnitRepository)
    {
        $units = $distanceUnitRepository->getAll();

        $this->assertCount(3, $units);
        $this->assertArrayHasKey('meter', $units);
        $this->assertArrayHasKey('foot', $units);
        $this->assertArrayHasKey('inch', $units);

    }
}
