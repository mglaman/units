<?php

namespace mglaman\Units\Tests\Model;

use mglaman\Units\Model\Unit;

/**
 * @coversDefaultClass \mglaman\Units\Model\Unit
 */
class UnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Unit
     */
    protected $unit;

    public function setUp()
    {
        $this->unit = new Unit();
    }

    /**
     * @covers ::setLabel
     * @covers ::getLabel
     */
    public function testLabel()
    {
        $this->unit->setLabel('yard');
        $this->assertEquals('yard', $this->unit->getLabel());
    }

    /**
     * @covers ::setPlural
     * @covers ::getPlural
     */
    public function testPlural()
    {
        $this->unit->setPlural('yards');
        $this->assertEquals('yards', $this->unit->getPlural());
    }

    /**
     * @covers ::setUnit
     * @covers ::getUnit
     */
    public function testUnit()
    {
        $this->unit->setUnit('yd');
        $this->assertEquals('yd', $this->unit->getUnit());
    }

    /**
     * @covers ::setFactor
     * @covers ::getFactor
     */
    public function testFactor()
    {
        $this->unit->setFactor(0.9144);
        $this->assertEquals(0.9144, $this->unit->getFactor());
    }

    /**
     * @covers ::toBase
     */
    public function testToBase()
    {
        $this->unit->setFactor(0.9144);
        $this->assertEquals(9.144, $this->unit->toBase(10));
    }

    /**
     * @covers ::toBase
     */
    public function testFromBase()
    {
        $this->unit->setFactor(0.9144);
        $this->assertEquals(1.09361, $this->unit->fromBase(1));
    }
}
