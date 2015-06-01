<?php

/**
 *
 */

namespace mglaman\Units\Model;

class Unit implements UnitInterface
{
    protected $label;
    protected $plural;
    protected $unit;
    protected $factor;

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlural()
    {
        return $this->plural;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlural($plural)
    {
        $this->plural = $plural;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * {@inheritdoc}
     */
    public function setFactor($float)
    {
        $this->factor = $float;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toBase($value)
    {
        return $this->round($value * $this->getFactor());
    }

    /**
     * {@inheritdoc}
     */
    public function fromBase($value)
    {
        return $this->round($value / $this->getFactor());
    }

    /**
     * Rounds a value to 5 decimal places.
     *
     * @param float $value Float to round.
     *
     * @return float
     */
    protected function round($value)
    {
        return round($value, 5);
    }
}
