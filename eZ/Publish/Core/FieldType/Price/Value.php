<?php

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    /**
     * @var float
     */
    public $price;

    public function __toString()
    {
        return (string)$this->price;
    }
}