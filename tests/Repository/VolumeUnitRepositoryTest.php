<?php

namespace mglaman\Units\Tests\Repository;

use mglaman\Units\Repository\VolumeUnitRepository;
use org\bovigo\vfs\vfsStream;

/**
 * @coversDefaultClass \mglaman\Units\Repository\VolumeUnitRepository
 */
class VolumeUnitRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Units.
     *
     * @var array
     */
    protected $units = [
        'liter' => [
            'label' => 'liter',
            'plural' => 'liters',
            'unit' => 'l',
            'factor' => 1e-3,
        ],
        'cup' => [
          'label' => 'cup',
          'plural' => 'cups',
          'unit' => 'cup',
          'factor' => 2.365882e-4,
        ],
    ];

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        // Mock the existence of JSON definitions on the filesystem.
        $root = vfsStream::setup('resources');
        $directory = vfsStream::newDirectory('volume')->at($root);
        foreach ($this->units as $name => $data) {
            $filename = $name . '.json';
            vfsStream::newFile($filename)->at($directory)->setContent(json_encode($data));
        }

        $volumeUnitRepository = new VolumeUnitRepository('vfs://resources/volume/');
        $unitsPath = $this->getObjectAttribute($volumeUnitRepository, 'unitsPath');
        $this->assertEquals('vfs://resources/volume/', $unitsPath);

        return $volumeUnitRepository;
    }

    /**
     * @covers ::getType
     * @depends testConstructor
     *
     * @param VolumeUnitRepository $volumeUnitRepository
     */
    public function testGetType($volumeUnitRepository)
    {
        $this->assertEquals('volume', $volumeUnitRepository->getType());
    }

    /**
     * @covers ::getUnit
     * @depends testConstructor
     *
     * @param VolumeUnitRepository $volumeUnitRepository
     */
    public function testGetUnit($volumeUnitRepository)
    {
        $foot = $volumeUnitRepository->getUnit('cup');

        $this->assertInstanceOf('mglaman\Units\Model\Unit', $foot);
        $this->assertEquals('cup', $foot->getLabel());
        $this->assertEquals('cups', $foot->getPlural());
        $this->assertEquals('cup', $foot->getUnit());
        $this->assertEquals(2.365882e-4, $foot->getFactor());
    }

    /**
     * @covers ::getAll
     * @depends testConstructor
     *
     * @param volumeUnitRepository $volumeUnitRepository
     */
    public function testGetAll($volumeUnitRepository)
    {
        $units = $volumeUnitRepository->getAll();

        $this->assertCount(2, $units);
        $this->assertArrayHasKey('liter', $units);
        $this->assertArrayHasKey('cup', $units);

    }
}
