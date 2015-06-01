<?php

namespace mglaman\Units\Tests\Repository;

use mglaman\Units\Repository\WeightUnitRepository;
use org\bovigo\vfs\vfsStream;

/**
 * @coversDefaultClass \mglaman\Units\Repository\WeightUnitRepository
 */
class WeightUnitRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Units.
     *
     * @var array
     */
    protected $units = [
        'gram' => [
            'label' => 'gram',
            'plural' => 'grams',
            'unit' => 'g',
            'factor' => 1e-3,
        ],
        'kilogram' => [
          'label' => 'kilogram',
          'plural' => 'kilograms',
          'unit' => 'kg',
          'factor' => 1,
        ],
        'pound' => [
          'label' => 'pound',
          'plural' => 'pounds',
          'unit' => 'lbs',
          'factor' => 0.45359237,
        ],
    ];

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        // Mock the existence of JSON definitions on the filesystem.
        $root = vfsStream::setup('resources');
        $directory = vfsStream::newDirectory('weight')->at($root);
        foreach ($this->units as $name => $data) {
            $filename = $name . '.json';
            vfsStream::newFile($filename)->at($directory)->setContent(json_encode($data));
        }

        $weightUnitRepository = new WeightUnitRepository('vfs://resources/weight/');
        $unitsPath = $this->getObjectAttribute($weightUnitRepository, 'unitsPath');
        $this->assertEquals('vfs://resources/weight/', $unitsPath);

        return $weightUnitRepository;
    }

    /**
     * @covers ::getType
     * @depends testConstructor
     *
     * @param WeightUnitRepository $weightUnitRepository
     */
    public function testGetType($weightUnitRepository)
    {
        $this->assertEquals('weight', $weightUnitRepository->getType());
    }

    /**
     * @covers ::getUnit
     * @depends testConstructor
     *
     * @param WeightUnitRepository $weightUnitRepository
     */
    public function testGetUnit($weightUnitRepository)
    {
        $foot = $weightUnitRepository->getUnit('pound');

        $this->assertInstanceOf('mglaman\Units\Model\Unit', $foot);
        $this->assertEquals('pound', $foot->getLabel());
        $this->assertEquals('pounds', $foot->getPlural());
        $this->assertEquals('lbs', $foot->getUnit());
        $this->assertEquals(0.45359237, $foot->getFactor());
    }

    /**
     * @covers ::getAll
     * @depends testConstructor
     *
     * @param WeightUnitRepository $weightUnitRepository
     */
    public function testGetAll($weightUnitRepository)
    {
        $units = $weightUnitRepository->getAll();

        $this->assertCount(3, $units);
        $this->assertArrayHasKey('gram', $units);
        $this->assertArrayHasKey('kilogram', $units);
        $this->assertArrayHasKey('pound', $units);

    }
}
